<?php
$url = $_SERVER['REQUEST_URI'] ?? '';

include 'db.php';



$url = str_replace('/','',$url);
// echo $url;
$result = $conn->query("SELECT * FROM notes_url WHERE url = '$url'");
if ($result->num_rows > 0) {
    $url = $result->fetch_assoc();
} else {
    $url = false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protected Text</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>-->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="//rawgit.com/notifyjs/notifyjs/master/dist/notify.js"></script>
    <style>
        body {
            background-color: #eef2f5;
        }
        .navbar {
            background-color: #2cace0;
            color: white;
        }
        .container {
            margin-top: 20px;
        }
        .note-container {
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-group button {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark px-3">
        <a class="navbar-brand" href="#">PROTECTED <strong>TEXT</strong></a>
        <div class="ms-auto">
            <a href="/<?= $url['url'] ?? '' ?>" class="btn btn-primary btn-sm">Reload</a>
            <button onclick="saveNotes()" type="button" class="btn btn-success btn-sm">Save</button>
            <button onclick="$('#newPasswordModal').modal('toggle')" type="button" class="btn btn-warning btn-sm newPasswordBtn" style="display: none;" >Change password</button>
            <button onclick="deleteNote()" type="button" class="btn btn-danger btn-sm">Delete</button>
        </div>
    </nav>
    <div class="container">
        <div class="note-container">
            <div class="d-flex mb-2 notestabs ">
                <button class="btn btn-outline-secondary btn-sm ms-2">+</button>
            </div>
            <textarea id="notesTextID" onkeyup="notesText(this.value)" class="form-control" rows="15" placeholder="your text goes here..."></textarea>
        </div>
    </div>


    <div class="modal fade" id="newPasswordModal" tabindex="-1" role="dialog" aria-labelledby="newPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
            Set New Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <label for="newpassword">Password</label>
                <input type="password" class="form-control" id="newpassword" name="newpassword"  placeholder="Enter Password...">
              </div>
          </div>
          <div class="modal-footer">
             <button onclick="SetNewPass()" type="button" class="btn btn-primary">Set</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              <?php
              // var_dump($url['pass']);
              if(($url['pass'] ?? '') == ''){
                echo 'Set';
              } else {
                echo 'Enter';
              }
              ?>
               Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" class="form-control" id="Password" name="Password"  placeholder="Enter Password...">
                <?php
                if(($url['pass'] ?? '') == ''){
                  ?>
                  <small id="emailHelp" class="form-text text-muted">This is use to protect your notes.</small>
                  <?php
                } 
                ?>
                
              </div>
            
          </div>
          <div class="modal-footer">
              <?php
              if(($url['pass'] ?? '') == ''){
                ?>
                <button onclick="CheckPass()" type="button" class="btn btn-primary">Set</button>
                <?php
                
              } else {
                ?>
                <button onclick="CheckPass()" type="button" class="btn btn-primary">Unlock</button>
                <?php
                
              }
              ?>
            
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <?php
    if(!$url){?>
    
    <div class="modal fade" id="urlModal" tabindex="-1" role="dialog" aria-labelledby="urlModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create Url</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="url.php" method="POST" >
          <div class="modal-body">
            
              <div class="form-group">
                <label for="url">URL</label>
                <input type="text" class="form-control" id="url" name="url"  placeholder="Enter Url...">
                <small id="emailHelp" class="form-text text-muted">This can be use to access your notes.</small>
              </div>
            
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    
    <script>
        $('#urlModal').modal('toggle');
        $('[name=url]').on('keyup',function(){
            $('[name=url]').removeClass('is-valid');
            $('[name=url]').addClass('is-invalid');
            
           
            $.ajax({
                method: 'post',
                url: '/check_url.php',
                data: {url: $('[name=url]').val()},
                success: function(res){
                res = JSON.parse(res);
                    if(res['exists']){
                        $('[name=url]').removeClass('is-valid');
                        $('[name=url]').addClass('is-invalid');
                    } else {
                        $('[name=url]').addClass('is-valid');
                        $('[name=url]').removeClass('is-invalid');
                    }
                }
            })
        })
    </script>

    
        
    <?php
    }
    // print_r($url);
    if($url){ ?>
        <script>
            let password ='';
            if(password == ''){
                $('#passwordModal').modal('toggle');
            }
            $(document).ready(()=>{
              
            })
        </script>
    <?php
    }
    ?>

    <script>
      function CheckPass(){
            password = $('[name=Password]').val();
            if(password.length < 3){
              $('[name=Password]').removeClass('is-valid');
              $('[name=Password]').addClass('is-invalid');
              return '';
            }
            let url = '<?= $url['url'] ?? '' ?>';
            $.ajax({
                method: 'post',
                url: '/password.php',
                data: {url: url,pass: $('[name=Password]').val()},
                success: function(res){
                res = JSON.parse(res);
                    if(res['response']){
                        $('[name=Password]').addClass('is-valid');
                        $('[name=Password]').removeClass('is-invalid');
                        getNotes();
                        setTimeout(() => {
                          $('#passwordModal').modal('toggle');
                          $('.newPasswordBtn').show();
                        }, 1000);
                    } else {
                        $('[name=Password]').removeClass('is-valid');
                        $('[name=Password]').addClass('is-invalid');
                    }
                }
            })
      }
      function getNotes(){
        let url = '<?= $url['url'] ?? '' ?>';
        $.ajax({
            method: 'post',
            url: '/get_notes.php',
            data: {url: url,pass: password},
            success: function(res){
            res = JSON.parse(res);
                if(res['response']){
                  let html = '';
                  for (i in res['notes']){
                      active = '';
                      if(i == 0){ active = 'active'}
                      html += `<button onclick="selectNote(this)" data-id="`+res['notes'][i]['id']+`" class="btn btn-outline-secondary btn-sm ms-2 notesbtn `+active+`">`+res['notes'][i]['title']+`</button>`;
                  }
                  notesTextID.value = hex2bin(res['notes'][0]['text']);
                  html += `<button onclick="addNewNotes()" class="btn btn-outline-secondary btn-sm ms-2">+</button>`;
                  $('.notestabs').html(html);
                }
            }
        })
      }
      function notesText(txt){
        let title = txt.split("\n")[0].substr(0,10);
        $('.notesbtn.active').text(title)
      }
      
          hex2bin = function (a)
          {

            var i = 0, l = a.length - 1, bytes = []

            for (i; i < l; i += 2)
            {
              bytes.push(parseInt(a.substr(i, 2), 16))
            }

            return String.fromCharCode.apply(String, bytes)   

          }

          bin2hex = function (a)
          {

            var i = 0, l = a.length, chr, hex = ''

            for (i; i < l; ++i)
            {

              chr = a.charCodeAt(i).toString(16)

              hex += chr.length < 2 ? '0' + chr : chr

            }

            return hex

          }
      
      function saveNotes(){
        
        let url = '<?= $url['url'] ?? '' ?>';
        $.ajax({
            method: 'post',
            url: '/save_notes.php',
            data: {url: url,pass: password,id: $('.notesbtn.active').data('id'),title: $('.notesbtn.active').text(),text: bin2hex(notesTextID.value)},
            success: function(res){
              $.notify("Saved", "success");
            }
        })
      }
      function addNewNotes(){
        $.notify("Adding...", "success");
        let url = '<?= $url['url'] ?? '' ?>';
        $.ajax({
            method: 'post',
            url: '/add_new_notes.php',
            data: {url: url,pass: password},
            success: function(res){
              res = JSON.parse(res);
              if(res['response']){
                  let html = '';
                  for (i in res['notes']){
                      active = '';
                      if(i == 0){ active = 'active'}
                      html += `<button onclick="selectNote(this)" data-id="`+res['notes'][i]['id']+`" class="btn btn-outline-secondary btn-sm ms-2 notesbtn `+active+`">`+res['notes'][i]['title']+`</button>`;
                  }
                  notesTextID.value = hex2bin(res['notes'][0]['text']);
                  html += `<button onclick="addNewNotes()" class="btn btn-outline-secondary btn-sm ms-2">+</button>`;
                  $('.notestabs').html(html);
                }
            }
        })
      }

      function selectNote(node){
        $(node).siblings().removeClass('active');
        $(node).addClass('active');
        let url = '<?= $url['url'] ?? '' ?>';
        notesTextID.value = '';
        $.ajax({
            method: 'post',
            url: '/get_note.php',
            data: {url: url,pass: password,id: $('.notesbtn.active').data('id')},
            success: function(res){
              res = JSON.parse(res);
              notesTextID.value = hex2bin(res['text']);  
            }
        })
      }
      function deleteNote(){
        let url = '<?= $url['url'] ?? '' ?>';
        notesTextID.value = '';
        if(confirm("Are you sure want to delete?")){
          $.ajax({
              method: 'post',
              url: '/delete_note.php',
              data: {url: url,pass: password,id: $('.notesbtn.active').data('id')},
              success: function(res){
                window.location.reload();
              }
          })
        }
      }
      function SetNewPass(){
        let url = '<?= $url['url'] ?? '' ?>';
        notesTextID.value = '';
        if(confirm("Are you sure want to change?")){
          $.ajax({
              method: 'post',
              url: '/change_pass.php',
              data: {url: url,pass: password,newpass: newpassword.value},
              success: function(res){
                window.location.reload();
              }
          })
        }
      }
    </script>

    
    
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
</body>
</html>
