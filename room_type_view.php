<?php require_once('header.php'); ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">View Room Types</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Room Type Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        $q = $pdo->prepare("SELECT * FROM room_type ORDER BY room_type_id ASC");
                        $q->execute();
                        $res = $q->fetchAll();
                        foreach ($res as $row) 
                        {
                            $i++;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td><?php echo $row['room_type_name']; ?></td>
                                <td>
                                    <a href="room_type_edit.php?id=<?php echo $row['room_type_id']; ?>" class="btn btn-xs btn-warning">Edit</a>
                                    <a href="room_type_delete.php?id=<?php echo $row['room_type_id']; ?>" class="btn btn-xs btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php require_once('footer.php'); ?>