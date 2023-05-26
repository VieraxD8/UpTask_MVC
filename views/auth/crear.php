<div class="contenedor crear">

   
<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>


    <div class="contenedor-sm">

        <p class="descripcion-pagina">Crea tu cuenta en Uptask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/crear" method="post" class="formulario">

            <div class="campo">

            <label for="nombre">Nombre</label>
            <input 
                    name="nombre"
                    id="nombre"
                    placeholder="Nombre"
                    type="text"
                    value="<?php echo $usuario->nombre; ?>"
            />

            </div>


            <div class="campo">

                <label for="email">Email</label>
                <input 
                        name="email"
                        id="email"
                        placeholder="Email"
                        type="email"
                        value="<?php echo $usuario->email; ?>"
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

            <div class="campo">

            <label for="password2">Repetir Password</label>
            <input 
                    name="password2"
                    id="password2"
                    placeholder="Repite tu Password"
                    type="password"
            />

            </div>

            <input type="submit" class="boton" value="Crear Cuenta" />

        </form>

        <div class="acciones">
            <a href='/'>¿Ya tienes una cuenta? Inicia Sesion</a>
        </div>

    </div><!--.contenedor-sm -->

</div>