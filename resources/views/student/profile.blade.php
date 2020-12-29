@extends(($viewer->role_id == 3 ? "layouts.instructor" : ($viewer->role_id == 1 ? "layouts.student" : "layouts.admin") ));

@section('content')
        
    <my-profile user="{{ $user }}" viewer="{{ $viewer }}"></my-profile>

@endsection