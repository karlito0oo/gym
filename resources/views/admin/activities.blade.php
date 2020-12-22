@extends(($user->role_id == 3 ? "layouts.instructor" : ($user->role_id == 1 ? "layouts.student" : "layouts.admin") ));

@section('content')

<activities-component user="{{ $user }}"></activities-component>

@endsection
