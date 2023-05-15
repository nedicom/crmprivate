<div class="col-2 px-3 py-3 border border-4 border-light" style="background-color: Cornsilk;;">
    <span class="px-1 fw-normal bg-white border border-white" style="font-size: 14px;!important">добавить</span>
    <div class="px-1 fw-normal bg-white border border-white d-flex flex-wrap"  style="height: 80px; overflow: hidden; position: relative;">
        <div>
            <a class="btn w-100 nameToForm" id="задача" onclick="Task(this.id)" href="#"
               data-client="{{$client->name}}" data-value-id="{{$client->id}}" data-bs-toggle="modal" data-bs-target="#taskModal" target="_blank">
                <i class="bi-clipboard-plus"></i>
            </a>
        </div>
        <div>
            <a class="btn w-100 nameToForm" id="звонок" onclick="myTask(this.id)" href="#"
               data-client="{{$client->name}}" data-value-id="{{$client->id}}" data-bs-toggle="modal" data-bs-target="#taskModal" target="_blank">
                <i class="bi bi-phone"></i>
            </a>
        </div>
        <div>
            <a class="btn w-100 nameToForm" id="консультация" onclick="myTask(this.id)" href="#"
               data-client="{{$client->name}}" data-value-id="{{$client->id}}" data-bs-toggle="modal" data-bs-target="#taskModal" target="_blank">
                <i class="bi bi-chat-dots"></i>
            </a>
        </div>
        <div>
            <a class="btn w-100 nameToForm" id="заседание" onclick="myTask(this.id)" href="#"
               data-client="{{$client->name}}" data-value-id="{{$client->id}}" data-bs-toggle="modal" data-bs-target="#taskModal" target="_blank">
                <i class="bi bi-briefcase"></i>
            </a>
        </div>
        <div>
            <a class="btn w-100 nameToForm" id="допрос" onclick="myTask(this.id)" href="#"
               data-client="{{$client->name}}" data-value-id="{{$client->id}}" data-bs-toggle="modal" data-bs-target="#taskModal" target="_blank">
                <i class="bi bi-emoji-neutral"></i>
            </a>
        </div>
    </div>
</div>
