import axios from 'axios';

const usernameSearchBtn = document.querySelector('#username-search');
const eventSearchBtn = document.querySelector('#event-search');
const token = document.querySelector('meta[name="api-token"]').content;

// Getting data from the API 
async function getData(type, data){
    try {
      const response = await axios({
        method: 'get',
        url: '/api/' + type + '/' + data,
        responseType: 'json',
        headers: {'Authorization': 'Bearer ' + token},
      });
      return response;
    } catch (error) {
      console.error(error);
    }
}

// Check if username search button exist
if (typeof(usernameSearchBtn) != 'undefined' && usernameSearchBtn != null){
    usernameSearchBtn.addEventListener('click', () => {
        const usernameField = document.querySelector('#username');
        let value = usernameField.value;
        if(value === '') {
            value = 'empty-value'
        }
        console.log('Search for user with the value of: ' + value);
        getData('user', value).then(function (response) {
            let data = response.data;
            let fullname = data.fullname;
            let identificationNumber = data.identification_number;
            let userSearchStatus = document.querySelector('#user-search-status');
            if(typeof fullname !== 'undefined'){
                // Change text of participant details
                let fullnameText = document.querySelector('#participant-fullname-text');
                let identificationNumberText = document.querySelector('#participant-identification-number-text');
                fullnameText.textContent = fullname.toUpperCase();
                identificationNumberText.textContent = identificationNumber;
                userSearchStatus.innerHTML = '<div class="alert alert-success">' + 'Pengguna dijumpai!' + '</div>';
            }else{
                // Display errors
                let emptyErr = data.Empty_Err;
                let notFoundErr = data.NotFound_Err;
                if(typeof emptyErr !== 'undefined'){
                    userSearchStatus.innerHTML = '<div class="alert alert-danger">' + 'Username Pengguna kosong diberikan!' + '</div>';
                }else if(typeof notFoundErr !== 'undefined'){
                    userSearchStatus.innerHTML = '<div class="alert alert-danger">' + 'Username Pengguna tidak dijumpai!' + '</div>';
                }else{
                    userSearchStatus.innerHTML = '';
                }
            }
        });
    });
}

// Check if event search button exist
if (typeof(eventSearchBtn) != 'undefined' && eventSearchBtn != null){
    eventSearchBtn.addEventListener('click', () => {
        const eventField = document.querySelector('#event-id');
        let value = eventField.value;
        if(value === '') {
            value = 'empty-value'
        }
        console.log('Search for event with the value of: ' + value);
        getData('event', value).then(function (response) {
            let data = response.data;
            let name = data.name;
            let date = data.date;
            let location = data.location;
            let organiserName = data.organiser_name;
            let visibility = data.visibility;
            let eventSearchStatus = document.querySelector('#event-search-status');
            if(typeof name !== 'undefined'){
                // Change text of event details
                let eventNameText = document.querySelector('#event-name-text');
                let eventDateText = document.querySelector('#event-date-text');
                let eventLocationText = document.querySelector('#event-location-text');
                let eventOrganiserNameText = document.querySelector('#event-organiser-name-text');
                let eventVisibilityText = document.querySelector('#event-visibility-text');
                eventNameText.textContent = name.toUpperCase();
                eventDateText.textContent = date;
                eventLocationText.textContent = location.toUpperCase();
                eventOrganiserNameText.textContent = organiserName.toUpperCase();
                switch (visibility) {
                    case 'public':
                        visibility = 'awam'
                        break;
                    case 'hidden':
                        visibility = 'tersembunyi'
                        break;
                    default:
                        break;
                }
                eventVisibilityText.textContent = visibility.toUpperCase();
                eventSearchStatus.innerHTML = '<div class="alert alert-success">' + 'Acara dijumpai!' + '</div>';
            }else{
                // Display errors
                let emptyErr = data.Empty_Err;
                let notFoundErr = data.NotFound_Err;
                if(typeof emptyErr !== 'undefined'){
                    eventSearchStatus.innerHTML = '<div class="alert alert-danger">' + 'ID Acara kosong diberikan!' + '</div>';
                }else if(typeof notFoundErr !== 'undefined'){
                    eventSearchStatus.innerHTML = '<div class="alert alert-danger">' + 'ID Acara tidak dijumpai!' + '</div>';
                }else{
                    eventSearchStatus.innerHTML = '';
                }
            }
        });
    });
}

