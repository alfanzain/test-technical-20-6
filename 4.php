<?php
// Database connection

$host		=	"localhost";
$user		=	"root";
$pw			=	"";
$db			=	"db_mobile_ganggu_dumbways";

$conn = new mysqli($host, $user, $pw, $db);


// Model
if(isset($_GET['action_type']) || isset($_POST['action_type']))
{
    // - Role -- Create
    if(@$_GET['action_type'] == 'add_role') {
        $addRoleQuery = $conn->query("INSERT INTO role VALUES (
            NULL, 
            '$_GET[role_name]'
        )");
    
        header("Location: 4.php");
    }

    // - Hero -- Create
    if(@$_POST['action_type'] == 'add_hero') {
        $limitSize = 10 * 1024 * 1024;
        $extension =  array('png','jpg','jpeg','gif');
        
        $fileName = $_FILES['hero_image']['name'];
        $tmp = $_FILES['hero_image']['tmp_name'];
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileSize = $_FILES['hero_image']['size'];

        if($fileSize > $limitSize){
            header("location:4.php?message=post_failed&error=size_too_big");		
        } else {
            if(!in_array($fileType, $extension)){
                header("location:4.php?message=post_failed&error=extension_unacceptable");		
            }else{
                $fileName = date('d-m-Y').'-'.$fileName;
                move_uploaded_file($tmp, 'hero_images/' . $fileName);

                $addHeroQuery = $conn->query("INSERT INTO hero VALUES (
                    NULL, 
                    '$_POST[hero_name]',
                    '$_POST[role]',
                    '$fileName',
                    '$_POST[hero_description]'
                )");

                if (!$addHeroQuery) {
                    printf("Error: %s\n", mysqli_error($conn));
                    exit();
                }

                header("location:4.php?message=post_success");
            }
        }
    }
}

// - Role -- Read
$roleQuery = $conn->query("SELECT * FROM role");

$listRole = [];

while($role = $roleQuery->fetch_assoc()) {
    array_push($listRole, $role);
}

// / End of Model
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Ganggu</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        body {
            margin: 0;
        }

        .header {
            margin-bottom: 100px;
            padding: 1.5rem 0;
        }

        .header .actions button {
            margin-right: 0.5rem;
        }

        .role-row {
            margin-bottom: 50px;
        }

        .hero-card {
            margin: 10px 0;
        }

        .hero-card .hero-name {
            text-transform: uppercase;
            letter-spacing: 0.2rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-9">
                    <h4>Mobile Ganggu</h4>
                </div>
                <div class="col-3 actions">
                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#hero-add-modal" >Add Hero</button>

                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#role-add-modal">Add Role</button>
                </div>
            </div>
        </div>

        <?php
        // List Role
        foreach ($listRole as $role)
        {
        ?>
        <div class="row role-row">
            <div class="col-12">
                <h4>
                    <?php echo $role['name']; ?>
                </h4>
        
                <div class="row hero-row">
                    <?php
                    // List Hero by Role
                    $heroQuery = $conn->query("SELECT * FROM hero WHERE id_role = " . $role['id']);

                    if($heroQuery->num_rows == 0) {
                    ?>
                        <div class="col-12 alert alert-info" role="alert">
                            No hero on this role yet.
                        </div>
                    <?php
                    } else {
                    ?>

                        <?php
                        while($hero = $heroQuery->fetch_assoc())
                        {
                            // print_r($hero);
                        ?>
                        
                        <div class="col-3">
                            <div class="card hero-card">
                                <img src="hero_images/<?php echo $hero['image'];  ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h6 class="hero-name">
                                        <?php echo $hero['name']; ?>
                                    </h6>
                                    <p class="card-text"><?php ?></p>
                                </div>
                            </div>
                        </div>

                    <?php
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
        <?php
        }
        ?>

    </div>

    <!-- Add role -->
    <div class="modal fade" id="role-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="get">
                <input type="hidden" name="action_type" value="add_role">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role-name-content" class="col-form-label">Role</label>
                            <input type="text" class="form-control" id="role-name-content" name="role_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add hero -->
    <div class="modal fade" id="hero-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action_type" value="add_hero">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Hero</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role-content" class="col-form-label">Role</label>
                            <select id="role-content" class="form-control" name="role" required>
                                <option value="">-- Choose Role --</option>
                                <?php
                                foreach ($listRole as $role)
                                {
                                ?>
                                    <option value="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hero-name-content" class="col-form-label">Name</label>
                            <input type="text" class="form-control" id="hero-name-content" name="hero_name" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="hero-image-content" class="col-form-label">Image</label>
                            <input type="file" class="form-control" id="hero-image-content" name="hero_image">
                        </div>
                        <div class="form-group">
                            <label for="hero-description-content" class="col-form-label">Description</label>
                            <textarea id="hero-description-content" class="form-control" name="hero_description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>