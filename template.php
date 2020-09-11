
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta last_name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


</head>

<body>

  <div class="jumbotron">
    <div class="container-fluid  w-75">


      <div class="card">
        <div class="card-header text-light bg-info">
          <h4>PHP CRUD</h4>
        </div>
        <div class="card-body bg-light">
          <form class="form-inline" method="POST">
            <input class="form-control m-2" name="first_name" placeholder="Vorname" value=<?= $first_name ?>>
            <input class="form-control m-2" name="last_name" placeholder="Name" value=<?= $last_name ?>>
            <input type="date" class="form-control m-2" name="birthday" placeholder="Geburtsdatum" value=<?= $birthday ?>>
            <input class="form-control m-2" name="gender" placeholder="F/M" value=<?= $gender ?>>
            <input type="email" class="form-control m-2" name="email" placeholder="Email" value=<?= $email ?>>
            <input type="hidden" name="ID" value=<?= $ID ?>>
            <br>
            <button type="submit" class="btn btn-info ml-4" value=<?= $save_update ?> name="button"> <?= $save_update ?></button>
          </form>
        </div>
      </div>


      <?php if ($info <> "") : ?>

        <div class="alert alert-<?= $alert_type ?> position-absolute" role="alert">
          <h5><?= $info ?></h5>
        </div>
      <?php endif ?>

      <div class="card mt-5">
        <div class="card-header">
          <form method="post">
            <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="Search">
              <div class="input-group-btn">
                <button class="btn btn-info" type="submit" name="button" value="search">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>

        <div class="card-body">
          <table class="table   table-striped ">
            <thead class="bg-info text-light">
              <tr>
                <th>first_name</th>
                <th>Name</th>
                <th>Email</th>
                <th>Geburtsdatum</th>
                <th>Geschlecht</th>
                <th>action</th>
              </tr>
            </thead>
            <?php foreach ($rows as $row) : ?>
              <tr>
                <td><?= $row['first_name'] ?></td>
                <td><?= $row['last_name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['birthday'] ?></td>
                <td><?= $row['gender'] ?></td>
                <td>
                  <form method="POST" class="form-inline">
                    <input type="hidden" name="ID" value=<?= $row['ID'] ?>>
                    <button type="submit" class="btn btn-info " value="edit" name="button">edit</button>
                    <button type="submit" class="btn btn-danger ml-2" value="delete" name="button">delete</button>
                  </form>
                  
                </td>
              </tr>
            <?php endforeach ?>


          </table>
          <div class="alert alert-dark" role="alert">
            <h5 class=" d-flex justify-content-end"><?= $info_DS ?></h5>
          </div>
        </div>
      </div>
    </div>
  </div>


</body>

</html>