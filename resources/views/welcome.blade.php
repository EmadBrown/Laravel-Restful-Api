<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>

    <link rel="stylesheet" href="https://bootswatch.com/4/darkly/bootstrap.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container">
      <h1>Add Item</h1>
      <form id="itemForm">
        <div class="form-group">
          <label>Text</label>
          <input type="text" id="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Body</label>
          <textarea id="body" class="form-control"></textarea>
        </div>
        <input type="submit" value="Submit" class="btn btn-primary">
      </form>
      <hr>
      <ul id="items" class="list-group"></ul>
  </div>

    <div class="container">
        <ul id="items" class="list-group"></ul>
    </div>

    <script
  src="https://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous"></script>


  <script type="text/javascript">
    $(document).ready(function(){
      getItems();

      // Submit event
      $('#itemForm').on('submit', function(e){
        e.preventDefault();

        let text = $('#text').val();
        let body = $('#body').val();

        addItem(text, body);
      });

      // Delete event
      $('body').on('click', '.deleteLink', function(e){
        e.preventDefault();

        let id = $(this).data('id');

        deleteItem(id);
      });

      // Delete item through api
      function deleteItem(id){
        $.ajax({
          method:'POST',
          url:'/api/items/'+id,
          method: 'DELETE',
        }).done(function(item){
          alert('Item Removed');
          location.reload();
        });
      }

      // Insert items using api
      function addItem(text, body){
        $.ajax({
          method:'POST',
          url:'api/items',
          data: {text: text, body: body}
        }).done(function(item){
          alert('Item # '+item.id+' added');
          location.reload();
        });
      }

      // Get items from API
      function getItems(){
        $.ajax({
          url:'api/items'
        }).done(function(items){
          let output = '';
          $.each(items, function(key, item){
            output += `
              <li class="list-group-item">
                <strong>${item.text}: </strong>${item.body}<br><a href="#" class="deleteLink btn btn-danger" data-id="${item.id}">Delete</a>
              </li>
            `;
          });
          $('#items').append(output);
        });
      }
    });
  </script>

  </body>
</html>
