@extends('layouts.app')

@section('title', 'Unverified Words')

@section('content')

    @php
        $dir = 'ltr';
        $language = '';
    @endphp
    @if ($word->language == 'BL')
        @php
            $dir = 'rtl';
            $language = 'Balochi';
        @endphp
    @elseif($word->language == 'UR')
        @php
            $dir = 'rtl';
            $language = 'Urdu';
        @endphp
    @elseif($word->language == 'EN')
        @php
            $dir = 'ltr';
            $language = 'English';
        @endphp
    @elseif($word->language == 'RB')
        @php
            $dir = 'ltr';
            $language = 'Roman Balochi';
        @endphp
    @endif

    <div class="container">
        <div class="row">
            <h1 class="soft-black text-secondary {{ $dir == 'rtl' ? 'mt-3' : '' }}">
                <i class="fa-solid fa-book"></i>
                Definition for word: &nbsp; <span
                    class="{{ $dir }} {{ $dir == 'rtl' ? 'urdu-f-l' : '' }}">{{ $word->word }}</span>
            </h1>
        </div>
        <br>
        @if ($word->status < 2)
            <div class="row">
                <form class="submit" method="post" action="{{ route('add_definition') }}">
                    @csrf
                    <div class="row">
                        <div class="col-10">
                            <label for="definition">Definition</label>
                            <input class="form-control {{ $dir }} {{ $dir == 'rtl' ? 'urdu-f-s' : '' }}"
                                id="definition" name="definition" type="text"
                                style="height: {{ $dir == 'rtl' ? '45px' : '' }}" dir="{{ $dir }}" required>
                        </div>
                        <div class="col-2">
                            <input name="word_id" type="hidden" value="{{ $word->id }}">
                            <br>
                            <input class="btn btn-primary submit" type="submit" value="Add Definition">
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <br>
        @endif
        <div class="data-table-container row bg-body">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Definition</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Definition</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td class="{{ $dir }} {{ $dir == 'rtl' ? 'urdu-f-s' : '' }}">{{ $row->definition }}
                            </td>
                            <td class="d-flex justify-content-end">
                                <a class="btn btn-primary mx-2 text-light"
                                    href="/example/definitionid/{{ $row->id }}">Examples</a>
                                @if ($word->status != 2)
                                    <button class="btn btn-danger submit mx-1"
                                        data-action="{{ route('delete_definition') }}" data-id="{{ $row->id }}"
                                        data-bs-target="#deleteModal" data-bs-toggle="modal">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
