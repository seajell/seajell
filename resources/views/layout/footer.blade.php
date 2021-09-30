{{-- First time login modal --}}
@if(session()->has('firstTimeLogin'))
    @if(session()->get('firstTimeLogin') == 'yes')
        <div class="modal modal-dialog-centered text-dark fade" id="first-time-login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="first-time-login-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="first-time-login-label">Selamat Datang Ke Sistem SeaJell</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Oleh kerana ini pertama kali anda log masuk, anda disarankan untuk menukar kata laluan anda di <a href="{{ route('user.update', [Auth::user()->username]) }}" class="text-dark" target="_blank">laman kemas kini profil pengguna</a>.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Faham!</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
@bukScripts(true)

{{-- Show first time login modal --}}
<script>
    $(document).ready(function(){
        $("#first-time-login").modal('show');
    });
</script>
