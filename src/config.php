<?php

return [
    /*
     * Title on pages
     */
    'title'        => 'Dashboard',
    /*
     * Credits in footer of page
     */
    'credits'      => 'Odot Media LLC',
    /*
     * Default role during user registration
     */
    'defaultRole'  => 'registered',
    /*
     * Allow registration by new users via registration form
     */
    'registration' => false,
    /*
     * Requires user activate before activation
     */
    'activations'  => false,
    /*
     * Use the default routes
     * - true, odotmedia/dashboard takes care of the routes
     * - false, you'll take care of routing yourself
     */
    'routes'       => true,
    /*
     * Override the view namespace
     */
    'view-namespace' => 'dashboard',
];
