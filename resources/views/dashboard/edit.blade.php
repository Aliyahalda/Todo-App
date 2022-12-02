@extends('layout')

@section('content')
<div class="container content">  
  <form id="create-form" method="POST" action="{{ route('todo.edit',$todo['id']) }}">
    @method('PATCH')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h3>Edit Todo</h3>
    @csrf
    <fieldset>
        <label for="">Title</label>
        <input placeholder="title of todo" type="text" name="title" value="{{ $todo['title'] }}">
    </fieldset>
    <fieldset>
        <label for="">Target Date</label>
        <input placeholder="Target Date" type="date" name="date" value="{{ $todo['date'] }}">
    </fieldset>
    <fieldset>
        <label for="">Description</label>
        <input type="text" placeholder="Type your descriptions here..."  name="description" value="{{ $todo['description'] }}"></input>
    </fieldset>
    <fieldset>
        <button name="submit" type="submit" id="contactus-submit">Recreate</button>
    </fieldset>
   <fieldset>
        <a href="/todo/" class="btn-cancel btn-lg btn">Cancel</a>
    </fieldset>
  
  </form>
</div>
@endsection