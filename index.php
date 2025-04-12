<?php include('./partials/header.php'); ?>

<?php
include('./config.php');
$sql = "SELECT * FROM todos ORDER BY ID DESC";
$result = mysqli_query($conn, $sql);
?>

<header>
</header>

<section class="documentation">
    <div class="container mt-4">
        <h2 class="text-center">Activity Log</h2>
        <p class="subtitle text-center">Tracking tasks and actions to meet goals.</p>
        <div class="documentation-inner">


            <?php if (mysqli_num_rows($result) > 0) { ?>
                <div style="position: static;" class="ps ps--active-y">
                    <div class="ps-content">


                        <ul class="list-group list-group-flush">
                            <?php $prevDate = null; ?>
                            <?php while ($todo = mysqli_fetch_assoc($result)) { ?>
                                <?php
                                $createdDate = date('Y-m-d', strtotime($todo['created_at']));
                                ?>

                                <?php if ($prevDate != $createdDate) { ?>
                                    <li class="list-group-item">
                                        <h6 class="mt-4 fw-bold text-theme">
                                            <i class="fa fa-calendar me-2"></i>
                                            <?php if ($createdDate == date('Y-m-d')) { ?>
                                                Today
                                            <?php } elseif ($createdDate == date('Y-m-d', strtotime('-1 day'))) { ?>
                                                Yesterday
                                            <?php } else { ?>
                                                <?php echo date('d M, Y', strtotime($createdDate)) ?>
                                            <?php } ?>
                                        </h6>
                                    </li>
                                <?php } ?>
                                <?php $prevDate = $createdDate; ?>

                                <li class="list-group-item">
                                    <div class="todo-indicator <?php echo ($todo['status'] == 'pending' ? "bg-danger" : ($todo['status'] == 'completed' ? "bg-success" : "bg-warning")); ?>"></div>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper ps-2">
                                            <div class="widget-content-left mr-2">
                                                <div class="custom-checkbox custom-control ps-0">
                                                    <i class="fa <?php echo ($todo['status'] == 'pending' ? " fa-close text-danger" : ($todo['status'] == 'completed' ? " fa-check text-success" : " fa-info text-warning")); ?> ms-0 px-1"></i>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading fs-8"><?php echo $todo['title']; ?></div>
                                                <div class="widget-subheading"><span><?php echo $todo['description']; ?></span></div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="time-text">
                                                    <?php echo date('h:i A', strtotime($todo['created_at'])); ?> - <?php echo date('h:i A', strtotime($todo['updated_at'])); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                    </div>

                </div>
            <?php } else { ?>
                <div class="alert alert-info" role="alert">
                    No data found.
                </div>
            <?php } ?>

        </div>

    </div>
</section>
<?php include('./partials/footer.php'); ?>