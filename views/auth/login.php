<div class="contenedor login">

<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">

        <p class="descripcion-pagina">Iniciar Sesion</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/" method="post" class="formulario" novalidate>

            <div class="campo">

                <label for="email">Email</label>
                <input 
                        name="email"
                        id="email"
                        placeholder="Email"
                        type="email"
                />

            </div>

            <div class="campo">

            <label for="password">Password</label>
            <input 
                    name="password"
                    id="password"
                    placeholder="Password"
                    type="password"
            />

            </div>

            <input type="submit" class="boton" value="Iniciar Sesion" />

        </form>

        <div class="acciones">
            <a href='/crear'>¿Aun no tienes una cuenta? Obtener una</a>
            <a href='/olvide'>Olvidaste tu  Password</a>
        </div>

    </div><!--.contenedor-sm -->

</div>