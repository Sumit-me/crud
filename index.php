<?php
$insert = false;
$update = false;
$delete = false;
//CONNECTING TO THE DATABASE
$servername = "localhost";
$username="root";
$password="";
$database="notes";

//CREATE A CONNECTION
$conn = mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("sorry connection is not successful because " .mysqli_connect_error());
}

//for delete record
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
  $result = mysqli_query($conn,$sql);
  $delete = true;

}

if ($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['snoEdit'])){
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];

    // update db information
    $sql = "UPDATE `notes` SET `Title` = '$title', `Description` = '$description' WHERE `notes`.`sno` = $sno ;";
    $result = mysqli_query($conn,$sql);
    if($result){
      //echo "Database created successfully...!";
      $update=true;
    }
    else{
      echo "we could not update the record successfully";
    }  
  }
  else{
    $title = $_POST['title'];
    $description = $_POST['description'];
  
    // create db information
    $sql = "INSERT INTO `notes` (`Title`, `Description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn,$sql);
    if($result){
      //echo "Database created successfully...!";
      $insert = true;
    
    }
    else{
      echo "Database isn't created...! -->". mysqi_error($conn);
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

  <title>crud project</title>

  </script>
</head>

<body>
  <!-- edit modal -->
  <!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
      Edit Modal
    </button>-->
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit notes</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/phpt/index.php" method="POST">
        <div class="modal-body">
          
            <input type="hidden" name="snoEdit" id="snoEdit">
            <h2>Add a Note</h2>
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="desc" class="form-label">Note Description</label>
              <input type="text" class="form-control" id="descriptionEdit" name="descriptionEdit" row="3">
            </div>
            <!--<button type="submit" class="btn btn-primary">Update Note</button>-->
          
        </div>
        <div class="modal-footer d-block mr-auto">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Note</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">PHP CRUD</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled">Contact us</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <?php
  if($insert){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Succes!</strong> Your note has been inserted succesfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if($update){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Succes!</strong> Your note has been updated succesfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    } 
    if($delete){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Succes!</strong> Your note has been deleted succesfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    } 
   ?>

  <div class="container my-4">
    <form action="/phpt/index.php" method="POST">
      <h2>Add a Note</h2>
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="desc" class="form-label">Note Description</label>
        <input type="text" class="form-control" id="description" name="description" row="3">
      </div>
      <button type="submit" class="btn btn-primary">Add note</button>
    </form>
  </div>

  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">s_no</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>

        <!-- for display database-->
        <?php
            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($conn,$sql);
      
            //find the number of the records returned
            $num = mysqli_num_rows($result);
            //echo $num. " records avaible...<br>";
            if($num>0){
              $sno=0;
              while($row=mysqli_fetch_assoc($result)){
                $sno = $sno+1;
                echo "<tr>
                <th scope='row'>".$sno."</th>
                <td>".$row['Title']."</td>
                <td>".$row['Description']."</td>
                <td><button class='edit btn btn-sm btn-primary'id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
              </tr>";
              //id=".$row['s no']."
              }
            }
            ?>

      </tbody>
    </table>
  </div>


  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log('edit',);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log('edit',);
        sno = e.target.id.substr(1,);

        if(confirm("Press a Button..!")){
          console.log("yes");
          window.location = `/phpt/index.php?delete=${sno}`;
        }
        else{
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>