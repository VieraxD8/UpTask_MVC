<div class="contenedor reestablecer">

<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">

    
        <p class="descripcion-pagina">Coloca tu Nuevo Password</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <?php  if($mostrar): ?>

      

        <form method="post" class="formulario">


            <div class="campo">

            <label for="password">Password</label>
            <input 
                    name="password"
                    id="password"
                    placeholder="Password"
                    type="password"
            />

            </div>

            <input type="submit" class="boton" value="Reestablecer" />

        </form>

        <?php endif ?>

        <div class="acciones">
            <a href='/crear'>¿Aun no tienes una cuenta? Obtener una</a>
            <a href='/olvide'>Olvidaste tu  Password</a>
        </div>

    </div><!--.contenedor-sm -->

</div>