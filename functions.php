<?php
/**
 * Tema Azi & Torres
 * functions.php
 */

// Block direct access
require_once __DIR__ . '/functions/security.php';

// Services & Core
require_once __DIR__ . '/functions/services/service-contact-form.php';
require_once __DIR__ . '/functions/enqueue.php';
require_once __DIR__ . '/functions/setup.php';
require_once __DIR__ . '/functions/meta.php';
require_once __DIR__ . '/functions/updates.php';

// Controllers
require_once __DIR__ . '/functions/controllers/controller-single.php';
require_once __DIR__ . '/functions/controllers/controller-contact.php';

// Post Types & Admin
require_once __DIR__ . '/functions/post-types.php';
require_once __DIR__ . '/functions/admin.php';

// AJAX & Utils
require_once __DIR__ . '/functions/ajax.php';
require_once __DIR__ . '/functions/template-tags.php';
