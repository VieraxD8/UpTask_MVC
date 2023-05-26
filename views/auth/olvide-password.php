<div class="contenedor olvide">

   
<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>


    <div class="contenedor-sm">

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <p class="descripcion-pagina">Recupera tu Acceso UpTask</p>

        <form action="/olvide" method="post" class="formulario" novalidate>


        <div class="campo">

        <label for="email">Email</label>
        <input 
                name="email"
                id="email"
                placeholder="Email"
                type="email"
        />

        </div>

            <input type="submit" class="boton" value="Recupera Password" />

        </form>

        
        <div class="acciones">
            <a href='/'>¿Ya tienes una cuenta? Inicia Sesion</a>
            <a href='/crear'>¿Aun no tienes una cuenta? Obtener una</a>
        </div>

    </div><!--.contenedor-sm -->

</div>