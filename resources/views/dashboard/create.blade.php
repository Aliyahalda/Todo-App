@extends('layout')

@section('content')
<div class="container content">  
  <form id="create-form" method="POST" action="/todo/store">
    @csrf
    <h3>Create Todo</h3> 
    
    <fieldset>
        <label for="">Title</label>
        <input placeholder="title of todo" type="text" name="title">
    </fieldset>
    <fieldset>
        <label for="">Target Date</label>
        <input placeholder="Target Date" type="date" name="date">
    </fieldset>
    <fieldset>
        <label for="">Description</label>
        <textarea placeholder="Type your descriptions here..." tabindex="5" name="description"></textarea>
    </fieldset>
    <fieldset>
        <button name="submit" type="submit" id="contactus-submit" ><i class="fa-solid fa-square-plus"></i> Submit</button>
    </fieldset>
    <fieldset>
        <a href="/todo/" class="btn-cancel btn-lg btn"><i class="fa-sharp fa-solid fa-xmark"></i> Cancel</a>
    </fieldset>
  
  </form>
</div>
@endsection