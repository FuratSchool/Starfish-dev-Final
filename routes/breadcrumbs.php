<?php
//Home route
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('landing'));
});
Breadcrumbs::register('login', function($breadcrumbs)  {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Login', route('login'));
});
Breadcrumbs::register('register', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Registratie', route('register'));
});

//specialists
Breadcrumbs::register('specialists', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Alle Specialisten', route('listSpecialists'));
});
Breadcrumbs::register('specialist', function($breadcrumbs, $spec)  {
    $breadcrumbs->parent('specialists');
    $breadcrumbs->push($spec->name, route('specialist', $spec));
});

//complaints
Breadcrumbs::register('complaints', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Alle Klachten', route('complaints'));
});
Breadcrumbs::register('complaint', function($breadcrumbs, $complaint)  {
    $breadcrumbs->parent('complaints');
    $breadcrumbs->push($complaint->name, route('complaint', $complaint));
});
//specialisms
Breadcrumbs::register('specialisms', function($breadcrumbs)  {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Alle Werkgebieden', route('specialisms'));
});
Breadcrumbs::register('specialism', function($breadcrumbs, $specialism)  {
    $breadcrumbs->parent('specialisms');
    $breadcrumbs->push($specialism->name, route('specialism', $specialism));
});
//search
Breadcrumbs::register('search_parent', function($breadcrumbs)  {
    $breadcrumbs->parent('home');
    $breadcrumbs->push("Zoeken");
});
Breadcrumbs::register('search_parent_spec', function($breadcrumbs)  {
    $breadcrumbs->parent('search_parent');
    $breadcrumbs->push("Werkgebied");
});
Breadcrumbs::register('search_parent_comp', function($breadcrumbs)  {
    $breadcrumbs->parent('search_parent');
    $breadcrumbs->push("Klacht");
});
Breadcrumbs::register('searchSpecialism', function($breadcrumbs, $query)  {
    $breadcrumbs->parent('search_parent_spec');
    $breadcrumbs->push($query, route('specialism', $query));
});
Breadcrumbs::register('searchComplaint', function($breadcrumbs, $query)  {
    $breadcrumbs->parent('search_parent_comp');
    $breadcrumbs->push($query, route('specialism', $query));
});

//admin crumbs
Breadcrumbs::register('admin', function($breadcrumbs)  {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Admin', route('admin.admin'));
});