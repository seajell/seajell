<?php

// Copyright (c) 2021 Muhammad Hanis Irfan bin Mohd Zaid

// This file is part of SeaJell.

// SeaJell is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// SeaJell is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with SeaJell.  If not, see <https://www.gnu.org/licenses/>.

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\NewAccountMail;
use Illuminate\Http\Request;
use App\Models\LoginActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as PHPSpreadsheetReaderException;

class UserController extends MainController
{
    public function loginView(Request $request)
    {
        return view('login')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
    }

    public function userListView(Request $request)
    {
        $pagination = 15;
        $users = User::paginate($pagination)->withQueryString();
        // Check for filters and search
        if ($request->filled('sort_by') and $request->filled('sort_order') and $request->has('search')) {
            $sortBy = $request->sort_by;
            $sortOrder = $request->sort_order;
            $search = $request->search;
            if (!empty($search)) {
                $users = User::where('id', 'LIKE', "%{$search}%")->orWhere('username', 'LIKE', "%{$search}%")->orWhere('fullname', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%")->orWhere('role', 'LIKE', "%{$search}%")->orderBy($sortBy, $sortOrder)->paginate($pagination)->withQueryString();
            } else {
                $users = User::orderBy($sortBy, $sortOrder)->paginate($pagination)->withQueryString();
            }
            $sortAndSearch = [
                'sortBy' => $sortBy,
                'sortOrder' => $sortOrder,
                'search' => $search,
            ];

            return view('user.list')->with(['sortAndSearch' => $sortAndSearch, 'users' => $users, 'appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
        } else {
            return view('user.list')->with(['users' => $users, 'appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
        }
    }

    public function addUserView(Request $request)
    {
        return view('user.add')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
    }

    public function updateUserView(Request $request, $username)
    {
        if ($data = User::where('username', $username)->first()) {
            // Only superadmin can edit their own profile
            if ('admin' == $username && 'admin' == Auth::user()->username) {
                return view('user.update')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, 'data' => $data]);
            // Only superadmin or an admin themselves can edit their own profile
            } elseif ('admin' == $data->role && Auth::user()->username == $username || 'superadmin' == Auth::user()->role) {
                return view('user.update')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, 'data' => $data]);
            // Admins and the user themselves can edit their own profile
            } elseif ('participant' == $data->role && Gate::allows('authAdmin') || Auth::user()->username == $username) {
                return view('user.update')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, 'data' => $data]);
            } else {
                abort(403, 'Anda tidak boleh mengakses laman ini.');
            }
        } else {
            abort(404, 'Pengguna tidak dijumpai.');
        }
    }

    /**
     * Login and Logout.
     */
    public function login(Request $request)
    {
        $username = strtolower($request->username);
        if (User::where('username', '=', $request->username)->first()) {
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $userID = User::select('id')->where('username', '=', $username)->first()->id;
                $user = User::find($userID);
                $token = $user->createToken('apitoken');
                // Add Bearer API Token to session
                $request->session()->put('bearerAPIToken', $token->plainTextToken);

                // Check if this is user first time login
                $firstTimeLoginStatus = User::select('first_time_login')->where('username', $username)->first()->first_time_login;
                if ('yes' == $firstTimeLoginStatus) {
                    $request->session()->flash('firstTimeLogin', 'yes');
                    User::where('id', $userID)
                        ->update(['first_time_login' => 'no']);
                }

                LoginActivity::create([
                    'user_id' => $userID,
                    'ip_address' => $request->ip(),
                    'http_user_agent' => $request->server('HTTP_USER_AGENT'),
                ]);

                return redirect()->intended();
            }

            return back()->withInput()->withErrors([
                'password' => 'Kata laluan salah.',
            ]);
        } else {
            return back()->withInput()->withErrors([
                'username' => 'Pengguna tidak wujud.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        if (null != auth()->user()->tokens()) {
            auth()->user()->tokens()->delete();
        }
        // Remove Bearer API Token from session
        if ($request->session()->has('bearerAPIToken')) {
            $request->session()->forget('bearerAPIToken');
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function addUser(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'fullname' => ['required'],
            'email' => ['required', 'email:rfc'],
            'password' => ['required', 'confirmed'],
            'identification_number' => ['required', 'numeric'],
            'role' => ['required'],
        ]);
        if (!User::select('username')->where('username', $request->username)->first()) {
            User::updateOrCreate(
                ['username' => strtolower($request->username)],
                ['fullname' => strtolower($request->fullname), 'email' => strtolower($request->email), 'password' => Hash::make($request->password), 'identification_number' => $request->identification_number, 'role' => strtolower($request->role)]
            );

            // Sending Email
            if (!empty($this->emailServiceSetting)) {
                if ('on' == $this->emailServiceSetting->service_status) {
                    if (!empty($this->emailServiceSetting->support_email)) {
                        $emailSupportEmail = $this->emailServiceSetting->support_email;
                    } else {
                        $emailSupportEmail = '';
                    }

                    if (!empty($this->systemSetting->logo)) {
                        $emailSystemLogo = $this->systemSetting->logo;
                    } else {
                        $emailSystemLogo = '';
                    }

                    if (!empty($this->systemSetting->name)) {
                        $emailSystemName = $this->systemSetting->name;
                    } else {
                        $emailSystemName = '';
                    }

                    $basicEmailDetails = [
                        'supportEmail' => strtolower($emailSupportEmail),
                        'systemLogo' => $emailSystemLogo,
                        'systemName' => $emailSystemName,
                    ];

                    $mailer = app()->makeWith('user.mailer');

                    $emailDetails = [
                        'username' => strtolower($request->username),
                        'password' => $request->password,
                    ];

                    $mailer->to(strtolower($request->email))->send(new NewAccountMail($basicEmailDetails, $emailDetails));
                }
            }

            $request->session()->flash('addUserSuccess', 'Pengguna berjaya ditambah!');

            return back();
        } else {
            return back()->withErrors([
                'userExisted' => 'Pengguna telah wujud!',
            ]);
        }
    }

    public function addUserBulk(Request $request)
    {
        $validated = $request->validate([
            'user_list' => ['required', 'mimes:xlsx'],
        ]);
        $inputFile = $request->file('user_list');
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly('1'); // Only read from worksheet named 1
        try {
            $spreadsheet = $reader->load($inputFile);
        } catch (PHPSpreadsheetReaderException $e) {
            exit('Error loading file: ' . $e->getMessage());
        }
        // Get all available rows. If a row is empty (in the username field), the rest of the row will be ignored. Warn the admin.
        $rows = $spreadsheet->getActiveSheet()->rangeToArray('B8:B507', null, false, false, true);
        if (empty($rows[8]['B'])) {
            return back()->withErrors([
                'sheetAtleastOne' => 'Sekurang-kurangnya satu data pengguna diperlukan!',
            ]);
        }

        $availableRows = [];
        foreach ($rows as $row => $value) {
            if (!empty($value['B'])) {
                array_push($availableRows, $row);
            } else {
                // If one row is empty in the username field, all the following rows will be ignored.
                break;
            }
        }

        $userData = [];
        foreach ($availableRows as $row) {
            $data = $spreadsheet->getActiveSheet()->rangeToArray('B' . $row . ':G' . $row, null, false, false, true);
            array_push($userData, $data);
        }
        $spreadsheetErr = [];
        $validUserList = [];
        foreach ($userData as $dataIndex) {
            foreach ($dataIndex as $data) {
                $username = strtolower($data['B']);
                $fullname = strtolower($data['C']);
                $email = strtolower($data['D']);
                $password = $data['E'];
                $identificationNo = $data['F'];
                $role = $data['G'];
                $currentRow = key($dataIndex);

                // Check if user already existed with the username
                if ('admin' == $username) {
                    // Check if adding user named 'admin'
                    $error = '[B' . $currentRow . '] ' . 'Anda tidak boleh menambah pengguna yang mempunyai username: admin!';
                    array_push($spreadsheetErr, $error);
                } elseif (User::where('username', strtolower($username))->first()) {
                    $error = '[B' . $currentRow . '] ' . 'Pengguna dengan username tersebut telah wujud!';
                    array_push($spreadsheetErr, $error);
                } else {
                    $usernameValid = $username;

                    if (empty($fullname)) {
                        $error = '[C' . $currentRow . '] ' . 'Ruangan nama penuh kosong!';
                        array_push($spreadsheetErr, $error);
                    } else {
                        $fullnameValid = $fullname;
                    }

                    if (empty($email)) {
                        $error = '[D' . $currentRow . '] ' . 'Ruangan alamat e-mel kosong!';
                        array_push($spreadsheetErr, $error);
                    } else {
                        // Check if email valid
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $error = '[D' . $currentRow . '] ' . 'Alamat e-mel mestilah merupakan alamat e-mel yang sah!';
                            array_push($spreadsheetErr, $error);
                        } else {
                            $emailValid = $email;
                        }
                    }

                    if (empty($password)) {
                        $error = '[E' . $currentRow . '] ' . 'Ruangan kata laluan kosong!';
                        array_push($spreadsheetErr, $error);
                    } else {
                        $passwordValid = $password;
                    }

                    if (empty($identificationNo)) {
                        $error = '[F' . $currentRow . '] ' . 'Ruangan nombor pengenalan kosong!';
                        array_push($spreadsheetErr, $error);
                    } else {
                        $identificationNoValid = $identificationNo;
                    }

                    if (empty($role)) {
                        $error = '[G' . $currentRow . '] ' . 'Ruangan peranan kosong!';
                        array_push($spreadsheetErr, $error);
                    } else {
                        // Check if role valid
                        // Only 1 and 2 can be inserted for role
                        // 1 = participant
                        // 2 = admin
                        if (1 == $role || 2 == $role) {
                            switch ($role) {
                                case 1:
                                    $roleValid = 'participant';
                                    break;
                                case 2:
                                    $roleValid = 'admin';
                                    break;
                                default:
                                    break;
                            }
                        } else {
                            $error = '[G' . $currentRow . '] ' . 'Hanya masukkan nombor yang diperlukan di ruangan peranan!';
                            array_push($spreadsheetErr, $error);
                        }
                    }
                    // Check if all valid data have been set
                    if (!empty($usernameValid) && !empty($fullnameValid) && !empty($emailValid) && !empty($passwordValid) && !empty($identificationNoValid) && !empty($roleValid)) {
                        $validUser = [
                            'username' => $usernameValid,
                            'fullname' => $fullnameValid,
                            'email' => $emailValid,
                            'password' => Hash::make($passwordValid),
                            'identification_number' => $identificationNoValid,
                            'role' => $roleValid,
                        ];
                        array_push($validUserList, $validUser);
                    }
                }
            }
        }
        // If if there's no problem with the spreadsheet, if doesn't, proceed to add the users.
        if (count($spreadsheetErr) > 0) {
            $request->session()->flash('spreadsheetErr', $spreadsheetErr);

            return back();
        } else {
            User::upsert($validUserList, ['username'], ['fullname', 'email', 'password', 'identification_number', 'role']);
            $request->session()->flash('spreadsheetSuccess', count($validUserList) . ' pengguna berjaya ditambah secara pukal!');

            return back();
        }
    }

    public function removeUser(Request $request)
    {
        $username = $request->username;
        if ('admin' == $username) {
            return back()->withErrors([
                'removeUserError' => 'Pengguna tersebut tidak boleh dibuang!',
            ]);
        } else {
            $user = User::where('username', $username);
            $user->delete();
            $request->session()->flash('removeUserSuccess', 'Pengguna berjaya dibuang!');

            return back();
        }
    }

    public function updateUser(Request $request, $username)
    {
        // Check whether update info or password
        if ($request->has('info')) {
            $validated = $request->validate([
                'fullname' => ['required'],
                'email' => ['required', 'email:rfc'],
                'identification_number' => ['required', 'numeric'],
                'role' => ['required'],
            ]);
            if (User::select('username')->where('username', $request->username)->first()) {
                User::updateOrCreate(
                    ['username' => strtolower($request->username)],
                    ['fullname' => strtolower($request->fullname), 'email' => strtolower($request->email), 'identification_number' => $request->identification_number, 'role' => strtolower($request->role)]
                );
                $request->session()->flash('updateUserSuccess', 'Pengguna berjaya dikemas kini!');

                return back();
            } else {
                return back()->withErrors([
                    'userNotExisted' => 'Pengguna tidak dijumpai!',
                ]);
            }
        } elseif ($request->has('password-update')) {
            // Only logged in user that need to change their own password need to enter old password
            // Admins changing participant password won't need to know the participant password
            if ($username == Auth::user()->username) {
                $validated = $request->validate([
                    'password' => ['required', 'confirmed'],
                    'old_password' => ['required'],
                ]);
            } else {
                $validated = $request->validate([
                    'password' => ['required', 'confirmed'],
                ]);
            }
            if (User::select('username')->where('username', $username)->first()) {
                $oldPassword = User::select('password')->where('username', $username)->first()->password;
                // If old password not empty, it means user is updating their own password
                if (!empty($request->input('old_password'))) {
                    // If old password input != old password from DB
                    $oldPasswordInput = $request->input('old_password');
                    if (!Hash::check($oldPasswordInput, $oldPassword)) {
                        return back()->withErrors([
                            'oldPasswordWrong' => 'Kata laluan lama salah!',
                        ]);
                    }
                }
                // Password is case sensitive
                User::updateOrCreate(
                    ['username' => strtolower($request->username)],
                    ['password' => Hash::make($request->password)]
                );
                $request->session()->flash('updateUserPasswordSuccess', 'Kata laluan pengguna berjaya dikemas kini!');

                return back();
            } else {
                return back()->withErrors([
                    'userNotExisted' => 'Pengguna tidak dijumpai!',
                ]);
            }
        } else {
            return back();
        }
    }
}
