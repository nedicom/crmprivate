@extends('layouts.app')

@section('title') Дело @endsection

@section('main')
    <div class="col-4 text-center">
        <div class="card border-light">
            <div class="card-body">
                <h5 class="card-title text-truncate">{{ $deal->name }}</h5>
                <p class="text-truncate">{{ $deal->description }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-truncate">{{ $deal->user->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ url($deal->user->avatar) }}" class="rounded-circle" style="width:30px;height:30px"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $deal->user->name }}">
                    </div>
                </div>
                <div class="mt-3 row d-flex justify-content-center">
                    <div class="col-2 mb-3">
                        <a class="btn btn-light w-100" href="#" data-value-id="{{ $deal->id }}" data-bs-toggle="modal" data-bs-target="#editDealModal">
                            <i class="bi-three-dots"></i>
                        </a>
                    </div>
                    <div class="col-2 mb-3">
                        <form action="{{ route('deal.delete', $deal->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-light w-100">
                                <i class="bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('/inc/modal/edit-deal')
