@extends('layouts.provider')

@section('content')
<div id="page-content-wrapper">
   <section class="maindiv">
      <div class="container">
        <div ng-view></div>
      </div>
   </section>
</div>
@endsection
