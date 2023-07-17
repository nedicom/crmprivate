@foreach ($services as $service)
    <li class="list-group-item serviceList serviceIndex" data-service-id="{{ $service->id }}">
        <a href="#" class="text-decoration-none">
            <span class="service-name">{{ $service->name }}</span>
            @if ($service->execution_time) (<span class="service-execution-time">Время выполнения: {{ $service->execution_time }} час)</span> @endif
        </a>
    </li>
@endforeach
