@extends('master')
 
<header>
    <nav>
        
    </nav>
</header>
<main>

    <section>
        <h1>Nova tarefa</h1>
        {{-- @if ($validator->any())
        <div>
            <ul>
                @foreach ($errors->all as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}
        <form action="{{ route('tasks.store') }}" method="post">
            @csrf
            <input type="text" name="title" value="{{ old('title') }}">
            <textarea name="description" rows="5">Textarea</textarea>
            <button type="submit">Store</button>
        </form>
    </section>

</main>


