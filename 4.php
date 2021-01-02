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
                $fileName = uniqid() . "." . $fileType;
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

    // - Hero -- Update
    if(@$_POST['action_type'] == 'edit_hero') {
        if($_FILES['hero_image']['name'])
        {
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
                    $fileName = uniqid() . "." . $fileType;
                    move_uploaded_file($tmp, 'hero_images/' . $fileName);

                    $heroName = $conn->real_escape_string($_POST['hero_name']);
                    $heroDescription = $conn->real_escape_string($_POST['hero_description']);
    
                    $editHeroQuery = $conn->query("UPDATE hero SET
                        name = '$heroName',
                        id_role = '$_POST[role]',
                        image = '$fileName',
                        deskripsi = '$heroDescription'
                        WHERE id = $_POST[hero_id]
                    ");
    
                    if (!$editHeroQuery) {
                        printf("Error: %s\n", mysqli_error($conn));
                        exit();
                    }
    
                    header("location:4.php?message=post_success");
                }
            }
        } else {
            $heroName = $conn->real_escape_string($_POST['hero_name']);
            $heroDescription = $conn->real_escape_string($_POST['hero_description']);

            $editHeroQuery = $conn->query("UPDATE hero SET
                name = '$heroName',
                id_role = '$_POST[role]',
                deskripsi = '$heroDescription'
                WHERE id = $_POST[hero_id]
            ");

            if (!$editHeroQuery) {
                printf("Error: %s\n", mysqli_error($conn));
                exit();
            }

            header("location:4.php?message=post_success");
        }
    }

    // - Hero -- Delete
    if(@$_GET['action_type'] == 'delete_hero') {
        $deleteHeroquery = $conn->query("DELETE FROM hero WHERE id = '$_GET[id_hero]'");

        if (!$deleteHeroquery) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }
        
        header("location:4.php?message=delete_success");
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

        .role-button-edit {
            font-size: 1rem;
            font-weight: bold;
        }
        
        .role-button-delete {
            font-size: 1rem;
            color: #ff1a0f; 
            font-weight: bold;
        }

        .hero-card {
            margin: 10px 0;
        }

        .hero-card .hero-name {
            text-transform: uppercase;
            letter-spacing: 0.2rem;
        }

        .hero-card .hero-detail {
            display: none;
        }

        .hero-card .hero-button-detail {
            width: 100%;
            display: block;
            margin-top: 2rem;
            font-size: 1rem;
            color: #fefefe;
        }

        .hero-card .card-footer, .hero-card .card-footer .row,  .hero-card .card-footer .col-6 {
            padding: 0;
            margin-left: 0;
            margin-right: 0;
        }

        .hero-card .card-footer a {
            display: block;
            border-radius: 0;
            color: #fefefe;
        }

        .hero-card .card-footer a.btn-primary {
            border-radius: 0 0 0 4px;
        }

        .hero-card .card-footer a.btn-danger {
            display: block;
            border-radius: 0 0 4px 0;
            color: #fefefe;
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
                    <?php echo $role['name']; ?> <a href="?action_type=edit_role&id_role=<?php echo $role['id'] ?>" class="role-button-edit">Edit</a> <a href="?action_type=delete_role&id_role=<?php echo $role['id'] ?>" class="role-button-delete">Delete</a>
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
                                <?php 
                                if($hero['image'] != null) {
                                ?>
                                <img src="hero_images/<?php echo $hero['image'];  ?>" class="card-img-top">
                                <?php
                                }
                                ?>
                                <div class="card-body">
                                    <h6 class="hero-name"><?php echo $hero['name']; ?></h6>
                                    <div class="hero-detail">
                                        <?php
                                        if($hero['image'] != null) {
                                        ?>
                                        <img src="hero_images/<?php echo $hero['image'];  ?>" class="card-img-top">
                                        
                                        <br />
                                        <br />
                                        <?php
                                        }
                                        ?>
                                        <h5>
                                            <?php echo $hero['name']; ?>
                                        </h5>
                                        <h6>
                                            <?php echo $role['name']; ?>
                                        </h6>
                                        <p class="hero-description"><?php echo $hero['deskripsi']; ?></p>
                                    </div>
                                    <button class="btn btn-info hero-button-detail" data-toggle="modal" data-target="#hero-detail-modal">Detail</button>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-6">
                                            <a class="btn btn-primary" data-toggle="modal" data-target="#hero-edit-modal" data-role="<?php echo $role['id']; ?>" data-hero="<?php echo $hero['id']; ?>">Edit</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="?action_type=delete_hero&id_hero=<?php echo $hero['id'] ?>" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
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

    <!-- Edit role -->
    <div class="modal fade" id="role-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="get">
                <input type="hidden" name="action_type" value="edit_role">
                <input type="hidden" name="id_role" value="">
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

    <!-- Edit hero -->
    <div class="modal fade" id="hero-edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action_type" value="edit_hero">
                <input type="hidden" name="hero_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Hero</h5>
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

    <!-- Detail hero -->
    <div class="modal fade" id="hero-detail-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Hero</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script class="">
        $('#hero-detail-modal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            
            var modal = $(this)
            modal.find('.modal-body').html( button.parent().parent().parent().find('.hero-detail').html() )
        })

        $('#hero-edit-modal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            
            var modal = $(this)

            modal.find('[name="role"]').val( button.data('role') )
            modal.find('[name="hero_id"]').val( button.data('hero') )
            modal.find('[name="hero_name"]').val( button.parent().parent().parent().parent().find('.hero-name').text() )
            modal.find('[name="hero_description"]').val( button.parent().parent().parent().parent().find('.hero-description').text() )
        })
    </script>
</body>
</html>