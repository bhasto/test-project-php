function findAllUsers() {
  return searchUsersByCity('');
}

function searchUsersByCity(city) {
  return $.ajax({
    url: '/search.php',
    dataType: 'json',
    data: {
      city: encodeURI(city)
    }
  }).promise();
}

function saveUser(user) {
  return $.ajax({
    url: '/create.php',
    type: 'POST',
    dataType: 'html',
    data: user
  }).promise();
}

function renderUsers(users) {
  return $.map(users, renderUser);
}

function renderUser(user) {
  var $row = $('<tr>');
  $row.append($('<td>').text(user.name));
  $row.append($('<td>').text(user.email));
  $row.append($('<td>').text(user.city));
  return $row;
}

function createCitySearchForm() {
  return $('<form class="form-inline"><label for="city-filter">City</label> <input input="text" name="city" id="city-filter" class="form-control input-sm" placeholder="Enter city to filter"/>');
}

$(document).ready(function() {
  $('#city-header').empty().append(createCitySearchForm());

  var usersByCity = Rx.Observable.fromEvent($('#city-filter'), 'input')
    .map(function (e) {
      return e.target.value
    })
    .throttle(500)
    .distinctUntilChanged()
    .map(function(city) {
      return Rx.Observable.fromPromise(searchUsersByCity(city));
    })
    .switch();


  var $userForm = $('#user-form');

  $userForm.bootstrapValidator({
    fields: {
      name: {
        validators: {
          notEmpty: {
            message: 'Invalid name'
          }
        }
      },

      email: {
        validators: {
          notEmpty: {
            message: 'Invalid e-mail'
          },

          emailAddress: {
            message: 'Invalid e-mail'
          }
        }
      },

      city: {
        validators: {
          notEmpty: {
            message: 'Invalid city'
          }
        }
      }
    }
  });


  var usersAfterSave = Rx.Observable.fromEvent($userForm, 'success.form.bv')
    .do(function(e) {
      e.preventDefault();
    })
    .map(function(e) {
      return {
        name: $('#name').val(),
        email: $('#email').val(),
        city: $('#city').val()
      };
    })
    .flatMap(function(user) {
      return Rx.Observable.fromPromise(saveUser(user));
    })
    .do(function() {
      $userForm.data('bootstrapValidator').resetForm(true)
    })
    .flatMap(function() {
      return Rx.Observable.fromPromise(findAllUsers());
    });


  var users = Rx.Observable.merge(usersAfterSave, usersByCity);

  users.subscribe(function(data) {
    $('#users').empty().append(renderUsers(data));
  });
});
