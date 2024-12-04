<?php if($paginator->lastPage() > 1): ?>
<nav>
    <ul class="pagination">
        <!--  -->
        <?php if($paginator->currentPage() > 1): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>">
                <span>&laquo;</span>
            </a>
        </li>
        <?php else: ?>
        <li class="page-item disabled">
            <a class="page-link" href="#"><span>&laquo;</span></a>
        </li>
        <?php endif; ?>

        <!--  -->
        <?php if($paginator->currentPage() - 3 >= 1): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo e($paginator->url(1)); ?>">1</a>
        </li>
        <?php endif; ?>

        <!--  -->
        <?php if($paginator->currentPage() - 4 >= 1): ?>
        <li class="page-item disabled">
            <a class="page-link" href="#"><span>...</span></a>
        </li>
        <?php endif; ?>

        <!--  -->
        <?php for($p = max(1, $paginator->currentPage() - 2); $p <= max(0, $paginator->currentPage() - 1); $p++): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo e($paginator->url($p)); ?>"><?php echo e($p); ?></a>
            </li>
            <?php endfor; ?>

            <!--  -->

            <li class="page-item active">
                <a class="page-link" href="javascript:"><?php echo e($paginator->currentPage()); ?></a>
            </li>

            <!--  -->
            <?php for($p = $paginator->currentPage() + 1; $p <= min($paginator->lastPage(), $paginator->currentPage() + 2); $p++): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo e($paginator->url($p)); ?>"><?php echo e($p); ?></a>
                </li>
                <?php endfor; ?>

                <!--  -->
                <?php if($paginator->currentPage() + 4 <= $paginator->lastPage()): ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#"><span>...</span></a>
                    </li>
                    <?php endif; ?>

                    <!--  -->
                    <?php if($paginator->currentPage() + 3 <= $paginator->lastPage()): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($paginator->url($paginator->lastPage())); ?>"><?php echo e($paginator->lastPage()); ?></a>
                        </li>
                        <?php endif; ?>

                        <!--  -->
                        <?php if($paginator->hasMorePages()): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>">&raquo;</a>
                        </li>
                        <?php else: ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#"><span>&raquo;</span></a>
                        </li>
                        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?><?php /**PATH D:\www\laravel_project\resources\views/shop1/layout/page.blade.php ENDPATH**/ ?>