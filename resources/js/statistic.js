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

import axios from 'axios';

document.addEventListener("DOMContentLoaded", function (event) {
    const token = document.querySelector('meta[name="api-token"]').content;
    const updateStatusHTML = document.querySelector('#update-status');
    const totalViewedHTML = document.querySelector('#total-viewed');
    const totalAddedHTML = document.querySelector('#total-added');
    const participantLoginHTML = document.querySelector('#participant-login');
    const adminLoginHTML = document.querySelector('#admin-login');
    const totalLoginHTML = document.querySelector('#total-login');
    const participantLoginPercentageHTML = document.querySelector('#participant-login-percentage');
    const adminLoginPercentageHTML = document.querySelector('#admin-login-percentage');
    const totalLoginPercentageHTML = document.querySelector('#total-login-percentage');

    const updateOptions = document.querySelector('#update-options');
    const updateOptionsBtn = document.querySelector('#update-options-btn');
    
    function clearData(){
        totalViewedHTML.innerHTML = "";
        totalAddedHTML.innerHTML = "";
        participantLoginHTML.innerHTML = "";
        adminLoginHTML.innerHTML = "";
        totalLoginHTML.innerHTML = "";
        participantLoginPercentageHTML.innerHTML = "";
        adminLoginPercentageHTML.innerHTML = "";
        totalLoginPercentageHTML.innerHTML = "";
    }

    async function getData(data){
        try {
            const response = await axios({
              method: 'get',
              url: '/api/statistic/' + data,
              responseType: 'json',
              headers: {'Authorization': 'Bearer ' + token},
            });
            return response;
          } catch (error) {
            console.error(error);
            return error;
          }
    }

    clearData();

    function getDataFor(dataFor){
        getData(dataFor).then(function (response) {
            clearData();
            let data = response.data;
            updateStatusHTML.innerHTML = '<div class="alert alert-warning w-50"><i class="bi bi-arrow-repeat"></i> Kemas kini sedang berlangsung!</div>';
            // Checkes whether is any data is not available
            if(data.totalParticipantLogin == null || data.totalAdminLogin == null || data.totalLogin == null || data.totalCertificateViewed == null || data.totalCertificateAdded == null){
                displayDataFor('error', data);
            }else{
                displayDataFor('success', data);
            }
        });
    }

    function displayDataFor(dataStatus, data){
        if(dataStatus === 'error'){
            setTimeout(function(){ 
                updateStatusHTML.innerHTML = '<div class="alert alert-danger w-50"><i class="bi bi-x"></i> Kemas kini gagal!</div>';
            }, 1000);
            participantLoginHTML.innerHTML = 'Error';
            adminLoginHTML.innerHTML = 'Error';
            totalLoginHTML.innerHTML = 'Error';
            participantLoginPercentageHTML.innerHTML = 'Error';
            adminLoginPercentageHTML.innerHTML = 'Error';
            totalLoginPercentageHTML.innerHTML = 'Error';
            totalViewedHTML.innerHTML = 'Error';
            totalAddedHTML.innerHTML = 'Error';
        }else if(dataStatus === 'success'){
            participantLoginHTML.innerHTML = data.totalParticipantLogin;
            adminLoginHTML.innerHTML = data.totalAdminLogin;
            totalLoginHTML.innerHTML = data.totalLogin;
            participantLoginPercentageHTML.innerHTML = Math.round(data.totalParticipantLogin / data.totalLogin* 100) + "%";
            adminLoginPercentageHTML.innerHTML = Math.round(data.totalAdminLogin / data.totalLogin * 100) + "%";
            totalLoginPercentageHTML.innerHTML = "100%";
            totalViewedHTML.innerHTML = data.totalCertificateViewed;
            totalAddedHTML.innerHTML = data.totalCertificateAdded;
            setTimeout(function(){ 
                updateStatusHTML.innerHTML = '<div class="alert alert-success w-50"><i class="bi bi-check"></i> Kemas kini berjaya!</div>';
            }, 1000);
        }
        // Clears back the status
        setTimeout(function(){ 
            updateStatusHTML.innerHTML = '';
        }, 2500);
    }

    // Display all data when DOM loaded
    getDataFor('all');
    
    updateOptionsBtn.addEventListener('click', () => {
        switch (updateOptions.value) {
            case 'all':
                getDataFor('all');
                break;
            case 'today':
                getDataFor('today');
                break;
            case 'month':
                getDataFor('month');
                break;
            case 'year':
                getDataFor('year');
                break;
            default:
                break;
        }  
    });
    
});