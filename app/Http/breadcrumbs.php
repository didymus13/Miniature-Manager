<?php

Breadcrumbs::register('home', function($breadcrumbs) {
   $breadcrumbs->push('Hobby Showcase', url('/'));
});

Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Dashboard', url('/home'));
});

Breadcrumbs::register('collections', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Collections', route('collections.index'));
});

Breadcrumbs::register('collection', function($breadcrumbs, $collection) {
   $breadcrumbs->parent('collections');
    $breadcrumbs->push($collection->label, route('collections.show', $collection->slug));
});

Breadcrumbs::register('miniature', function($breadcrumbs, $miniature) {
    $breadcrumbs->parent('collection', $miniature->collection);
    $breadcrumbs->push($miniature->label, route('miniatures.show', $miniature->slug));
});

Breadcrumbs::register('photo', function($breadcrumbs, $photo) {
    $breadcrumbs->parent('miniature', $photo->imageable);
    $breadcrumbs->push($photo->caption, route('photos.show', $photo->id));
});