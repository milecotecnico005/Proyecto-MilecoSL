<div class="btn-group"
    data-bs-toggle="tooltip" data-bs-placement="top" title="Acciones"
>
    <!-- Botón principal con icono de rueda -->
    <button 
        type="button" 
        class="btn btn-dark dropdown-toggle btn-sm" 
        data-bs-toggle="dropdown" 
        aria-expanded="false"
        <?php echo e(isset($id) ? 'id='.$id : ''); ?>

        <?php echo e(isset($disabled) ? 'disabled' : ''); ?>

    >
        <ion-icon name="settings-outline"></ion-icon> <!-- Icono de rueda -->
    </button>

    <!-- Dropdown que mostrará los botones pasados como slot -->
    <ul class="dropdown-menu p-3 align-items-md-start dropdown-menuActions">
        <div style="gap: 1rem" class="d-flex flex-row justify-content-center-flex-wrap styleFont">
            <?php echo e($slot); ?> <!-- Aquí se renderizan los botones hijos -->
        </div>
    </ul>
</div>

<style>
    .dropdown-menuActions{
        background: rgba( 255, 254, 254, 0.55 );
        box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
        backdrop-filter: blur( 18px );
        -webkit-backdrop-filter: blur( 18px );
        border-radius: 10px;
        border: 1px solid rgba( 255, 255, 255, 0.18 );
        font-size: clamp(0.6rem, 1.5vw, 1rem);
    }

    .styleFont button, .styleFont a{
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        font-size: clamp(0.6rem, 1.5vw, 1rem);
    }

</style><?php /**PATH D:\milecosl\resources\views/components/actions-button.blade.php ENDPATH**/ ?>