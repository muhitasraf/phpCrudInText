<?php 
require "inc/functions.php"; 
$info = '';
$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? '0';

if('seed' == $task){
    seed();
    $info = 'Seeding is complete...';
}

if('delete' == $task){
    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
    deleteStudent($id);
}

$fname = '';
$lname = '';
$roll = '';

if(isset($_POST['submit'])){
    $fname = filter_input(INPUT_POST,'fname',FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST,'lname',FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST,'roll',FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING);
    if($id){
        if($fname!='' && $lname!='' && $roll!=''){
            $result = updateStudent($id,$fname,$lname,$roll);
            if($result){
                header('location: /crudtxt/index.php?report');
            }else {
                $error = 1;
            }
            
        }
    }else {
        if($fname!='' && $lname!='' && $roll!=''){
            $result = addStudent($fname,$lname,$roll);
            if($result){
                header('location: /crudtxt/index.php?report');
            }else {
                $error = 1;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <title>Document</title>
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <!-- CSS Reset -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <!-- Milligram CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <link rel="stylesheet" href="asset/style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h1>CURD OPERATION IN TEXT FILE</h1>
                <p>This is a simple CRUD application in text file using raw php, HTML, CSS, JavaScript.</p>
                <?php include_once 'inc\templates\nav.php'; ?>
                <hr/>
                <p><?php if($info!=''){echo $info;} ?></p>
            </div> 
        </div>

        <?php if('1' == $error): ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <blockquote>
                        Roll already added!
                    </blockquote>
                </div>
            </div>
        <?php endif; ?>

        <?php if('report' == $task): ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <?php generateReport(); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if('add' == $task): ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <form action="/crudtxt/index.php?task=add" method="POST">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>">
                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll" value="<?php echo $roll; ?>">
                        <button type="submit" name="submit" class="button-primary">Save Student</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <?php if('edit' == $task): 
            $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
            $student = getStudent($id);
            if($student):   
            ?>
                <div class="row">
                    <div class="column column-60 column-offset-20">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <label for="fname">First Name</label>
                            <input type="text" name="fname" id="fname" value="<?php echo $student['fname']; ?>">
                            <label for="lname">Last Name</label>
                            <input type="text" name="lname" id="lname" value="<?php echo $student['lname']; ?>">
                            <label for="roll">Roll</label>
                            <input type="number" name="roll" id="roll" value="<?php echo $student['roll']; ?>">
                            <button type="submit" name="submit" class="button-primary">Save Student</button>
                        </form>
                    </div>
                </div>
            <?php 
            endif; 
        endif; 
        ?>

    </div>
</body>
</html>