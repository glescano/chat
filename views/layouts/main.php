<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            if (isset(Yii::$app->user->identity->id)) {
                $rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
            } else {
                $rolesUsuario = [];
            }
            ?>
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);


            // Opciones para el administrador
            $opciones = [];
            if (array_key_exists('administrador', $rolesUsuario)) {
                $opciones = [
                    ['label' => 'Usuarios', 'url' => ['/usuarios/index', 't' => 'u']],
                    ['label' => 'Asignaturas', 'url' => ['/asignaturas/index']],
                    ['label' => 'Docentes por Asignaturaa', 'url' => ['/asignaturas-docentes/index']],
                    ['label' => 'Sentencias de Apertura', 'url' => ['/sentencias-apertura/index']]];
            } elseif (array_key_exists('profesor', $rolesUsuario)) {
                $opciones = [
                    ['label' => 'Asignaturas', 'url' => ['/asignaturas/index']],
                    ['label' => 'Alumnos', 'url' => ['/usuarios/index', 't' => 'a']]
                ];
            } elseif (array_key_exists('estudiante', $rolesUsuario)) {
                $opciones = [
                    ['label' => 'Mis Asignaturas', 'url' => ['/asignaturas/asignaturas-alumnos']],
                    ['label' => 'Test de Estilos de Aprendizaje', 'url' => ['/usuarios/test-felder-silverman']]
                ];
            } elseif (Yii::$app->user->isGuest) {
                $opciones = [
                    ['label' => 'Login', 'url' => ['/site/login']]
                ];
            }
            $opciones[] =  (isset(Yii::$app->user->identity->id)) ? '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>' : '';

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $opciones,
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; Universidad Nacional de Santiago del Estero<br/> Facultad de Ciencias Exactas y Tecnolog&iacute;as<br/>Instituto de Investigaci&oacute;n en Inform&aacue;tica y Sistemas de Informaci&oacute;n<br/> <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
