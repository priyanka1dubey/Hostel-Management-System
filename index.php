<?php 
session_start();
if (!isset($_SESSION['rollnumber'])) {
  header("Location: login.php");
}
if (isset($_GET['logout'])) {
  unset($_SESSION['rollnumber']);
  session_destroy();
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <title>Housekeeper Student Dashboard</title>
  <?php require("meta.php"); ?>
</head>
<body data-bs-theme="dark">
  <!-- Side Navigation -->
  <?php require("sidenav.php"); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-success pb-6 pt-5 pt-md-6">
      <div class="container-fluid">
        <!-- Notification message -->
        <?php if (isset($_SESSION['student_logged'])) : ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-inner--text"><strong>Welcome to online Housekeeping service.</strong>
            <?php echo $_SESSION['student_logged']; unset($_SESSION['student_logged']); ?>
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif ?>
        <?php require("headerstats.php"); ?>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt-5">
      <div class="row mt-2 pb-5">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Housekeeping</h3>
                  <div class="form-check form-switch mx-4">
                    <input class="form-check-input p-2" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked onclick="myFunction()" style="border-color: black" />
                  </div>
                </div>
                <div class="col text-end">
                  <a href="request.php" class="btn btn-outline-success">Request</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Housekeeper</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time Requested</th>
                    <th scope="col">Time In</th>
                    <th scope="col">Time Out</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $requestrows = getRequests($_SESSION['rollnumber'], $db);
                  if(mysqli_num_rows($requestrows) > 0){
                    while ($row = mysqli_fetch_assoc($requestrows)) {
                  ?>
                  <tr>
                    <th scope="row">
                      <?php 
                      if($row['worker_id'] == NULL && $row['req_status'] == 0 ) {
                        echo "<span style='color:#EE801A'>Not Alloted</span> - " .$row['reqid'];
                      } 
                      else if($row['worker_id'] != NULL && $row['req_status'] == 1 ){
                        echo $row['name']." - <span style='color:#2980b9'>Alloted</span> - ".$row['reqid'];
                      }
                      else if($row['worker_id'] != NULL && $row['req_status'] == 2 ){
                        echo $row['name']." - <span style='color:#27ae60'>Served</span> - ".$row['reqid'];
                      }
                      ?>
                    </th>
                    <td>
                      <?php echo $row['date']; ?>
                    </td>
                    <td>
                      <?php 
                      $cleaningtime = $row['cleaningtime']; 
                      echo date('h:i a', strtotime($cleaningtime));
                      ?>
                    </td>
                    <td>
                      <?php 
                      if($row['timein'] == NULL) {
                        echo "<span style='color:#EE801A'>--</span>";
                      } 
                      else if($row['timein'] != NULL){
                        $timei = $row['timein']; 
                        echo date('h:i a', strtotime($timei));
                      }
                      ?>
                    </td>
                    <td>
                      <?php 
                      if($row['timeout'] == NULL) {
                        echo "<span style='color:#EE801A'>--</span>";
                      } 
                      else if($row['timeout'] != NULL){
                        $timeo = $row['timeout']; 
                        echo date('h:i a', strtotime($timeo));
                      }
                      ?>
                    </td>
                  </tr>
                  <?php }} ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    function myFunction() {
      var element = document.body;
      element.dataset.bsTheme = 
        element.dataset.bsTheme == "light" ? "dark" : "light";
    }
  </script>
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/argon.min.js"></script>
</body>
</html>
