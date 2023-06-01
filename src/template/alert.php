<?php if(isset($error) || isset($success)): ?>
    <div class="custom_float_alert alert alert-dismissible 
        <?php echo isset($error) ? 'alert-primary' : 'alert-success' ?>">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?php echo $error ?? $success ?>
    </div>
<?php endif; ?>