<?php
$message = $message ?? '';
?>
    <main class="not-found-page">
        <br>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="error-template">
                        <h1>
                            Произошла ошибка!</h1>
                        <br>
                        <div class="error-details">
                            <?= $message ?>
                        </div>
                        <br>
                        <div class="error-actions">
                            <a href="/" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                                Вернуться на главную </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php die(); ?>