<script>
$(document).ready(function(){
    $("#login").submit(function(){
        //$("#img_ajax").fadeIn('fast');
        var username = $('#User').val(), pass = $('#password').val();
        if (username==''){
            $("#log_error").html("Debe de Ingresar el Usuario!");
            $("#log_error").fadeIn('slown');
            //$("#img_ajax").fadeOut('slown');
        }else if(pass==''){
            $("#log_error").html("Debe de Ingresar la Clave!");
            $("#log_error").fadeIn('slown');
            //$("#img_ajax").fadeOut('slown');
        }
        else{
            $.ajax({
                type: "POST",
                url: "./modulos/login_ldpa.php",
                data: "username=" + username + "&pass=" + pass + "&action=val_log",
                success: function(msj){
                    //alert(msj);
                    if (msj==1){
                        document.location.reload();
                    }else if(msj==2){
                        $("#log_error").html("Usuario y/o Clave Inválidos");
                        $("#log_error").fadeIn('slown');
                        //$("#img_ajax").fadeOut('slown');
                        //setTimeout("$(\"#log_error\").fadeOut('slow')",5000);
                    }else if(msj==3){
                        $("#log_error").html("El Usuario no posee Privilegios para el Sistema");
                        $("#log_error").fadeIn('slown');
                        //$("#img_ajax").fadeOut('slown');
                    }else {
                        $("#log_error").html("Error con la Comunicación, Contacte al departamento AIT");
                        $("#log_error").html(msj);
                        $("#log_error").fadeIn('slown');
                        //$   ("#img_ajax").fadeOut('slown');
                    }               
                },
                error: function(x,err,msj){
                            if(x.status==0){
                            alert('You are offline!!\n Please Check Your Network.');
                            }else if(x.status==404){
                            alert('Requested URL not found.');
                            }else if(x.status==500){
                            alert('Internel Server Error.');
                            }else if(e=='parsererror'){
                            alert('Error.\nParsing JSON Request failed.');
                            }else if(e=='timeout'){
                            alert('Request Time out.');
                            }else {
                            alert('Unknow Error.\n'+x.responseText);
                            }
                        }
            });
        }
        return false;
    });
});
</script>
<div id="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <!-- <h3 class="panel-title">Inicie Sección</h3> -->
                        <img src="./img/Logo.png" alt="">
                    </div>
                    <div class="panel-body">
                        <form role="form" name="login" id="login">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" id="User" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Clave" id="password" type="password" value="">
                                </div>
                                <input value="Entrar" type="submit" class="btn btn-lg btn-success btn-block"/>
                            </fieldset>
                            <p></p>
                            <div id="log_error" class="log_error alert alert-danger">.</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>