<?php if(isset($error) || isset($success)): ?>
    <!-- Error -->
    <div class="custom_float_alert alert alert-dismissible alert-primary">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <?php echo $error ?? $success ?>
    </div>
<?php endif; ?>