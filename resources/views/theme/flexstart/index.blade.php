@extends('theme.flexstart.layouts.app')

@section('content')
    <!-- ======= Hero Section ======= -->
    @include('theme.flexstart.partial.slide')
    <!-- End Hero -->

    <!-- About Section -->
    @include('theme.flexstart.partial.about')
    <!-- /About Section -->

    <!-- Portfolio Section -->
    @include('theme.flexstart.partial.banner2')    
    <!-- /Portfolio Section -->

    <!-- Recent Posts Section -->
    @include('theme.flexstart.partial.posts')   
    <!-- /Recent Posts Section -->

    <!-- Team Section -->
    @include('theme.flexstart.partial.team')  
    <!-- /Team Section -->

    <!-- agenda Section -->
    @include('theme.flexstart.partial.agenda2') 
    <!-- /agenda Section -->

    <!-- Faq Section -->
    @include('theme.flexstart.partial.faq') 
    <!-- /Faq Section -->

    <!-- Related link Section -->
    @include('theme.flexstart.partial.relatedlink') 
    <!-- /Related link Section -->

    <!-- Stats Section -->
    @include('theme.flexstart.partial.visitor') 
    <!-- /Stats Section -->

    <!-- Contact Section -->
    @include('theme.flexstart.partial.contact') 
    <!-- /Contact Section -->

    
    <!-- agenda Section -->
    {{-- @include('theme.flexstart.partial.agenda')  --}}
    <!-- /agenda Section -->

@endsection

@section('description', $profil->seo_desc)
@section('keyword', $profil->seo_desc)
@section('title', $profil->name)
@section('name', $profil->name)
@section('image',   url('storage/' . $profil->logo)  )
