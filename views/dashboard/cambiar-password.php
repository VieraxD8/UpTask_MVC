
<?php include_once __DIR__ . '/header-dashboard.php';?>


<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/perfil" class="enlace">Volver al Perfil</a>

    <form action="/cambiar-password" class="formulario" method="POST">

    <div class="campo">
    <label for="password_actual">Password Actual</label>
    <input 
        type="password"
        name="password_actual"
        placeholder="tu Password Actual"
        />

    </div>

    <div class="campo">
    <label for="password_nuevo">Password Nuevo</label>
    <input 
        type="password"
        name="password_nuevo"
        placeholder="Tu Nuevo Password"
        />
    </div>


    <input type="submit" value="Guardar Cambio">

    </form>

</div>


<?php include_once __DIR__ . '/footer-dashboard.php';?>