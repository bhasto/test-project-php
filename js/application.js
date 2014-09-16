function searchUsersByCity(city) {
  return $.ajax({
    url: '/api/users.php',
    dataType: 'json',
    data: {
      city: window.encodeURI(city)
    }
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
  return $('<form class="form-inline"><label for="filter-city">City</label> <input input="text" name="city" id="city-filter" class="form-control input-sm" placeholder="Enter city to filter"/>');
}

$(document).ready(function() {
  $('#city-header').empty().append(createCitySearchForm());

  var $input = $('#city-filter');

  var cities = Rx.Observable.fromEvent($input, 'keyup')
    .map(function (e) {
      return e.target.value
    })
    .throttle(500)
    .distinctUntilChanged();

  var users = cities.flatMapLatest(searchUsersByCity);

  users.subscribe(function(data) {
    $('#users').empty().append(renderUsers(data));
  });
});
