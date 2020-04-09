<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', '***' );

/** Имя пользователя MySQL */
define( 'DB_USER', '***' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '***' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Q=l5Arh>eGI9ZgtCT3E@c:7D.Z@i.;-FoOqMT5?]*x4iefIi>jZ~4*BJP(JN1UD>' );
define( 'SECURE_AUTH_KEY',  'al97O}1a5264twOX@vK)%toMcq-U)jj[(D!2Ly~ImlU.5:u;e|y7itOH/6 [k%gU' );
define( 'LOGGED_IN_KEY',    'UcZ-;;t: k!mRAWnVoWL577.H#8U6=m%huXS090YGj=JGmg=t?ER*-3mDIT7I%)a' );
define( 'NONCE_KEY',        '*=ttJ=aF0>x}tz@K(Gt#feY{{1b]9j1t3vE|tWnOKas|cHwT]K;G~~:Y<O)qGA]c' );
define( 'AUTH_SALT',        '^KW7x7$}T@3V@w1?e# nZI|S1cguf6^FgW{ea_I~-M.[b#t$?jZF[+/Q<@u;E^]v' );
define( 'SECURE_AUTH_SALT', 'u~tyQ$mAXhYd==Q(:#U,tA&^A8W:v%,rAy$jqJN4#A*HvKBjPiuHG0^@z`b5Zv04' );
define( 'LOGGED_IN_SALT',   'ijw(*,Q.&HCa&%r#:s<FYY]TEY^j:zE)VmuR0Eo8S]EKf%_hnGMVma8bDz7[#=;b' );
define( 'NONCE_SALT',       ',eikBseBvjcr}okWFH{^&1ouN6P}5 F+Pt@SL6[F9ohy-_Q%H++`2qO<ceR+/Sbp' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
