<tr class="table">
    <td></td>
    <td>{{$user->created_at}}</td>
    <td>{{$user->name}}</td>
    <td>{{$user->email}}</td>
    <td><span>{{ \App\Helpers\UserHelper::nameStatus($user) }}</span></td>
    <td><span>{{ \App\Helpers\UserHelper::nameRole($user) }}</span></td>
    <td>
        <a class="btn btn-light w-100" href="{{ route ('users.show', $user) }}">
            <i class="bi-three-dots"></i>
        </a>
    </td>
</tr>
