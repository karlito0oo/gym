@extends(($user->role_id == 3 ? "layouts.instructor" : "layouts.admin" ));

@section('content')

<sections-component user="{{ $user }}"></sections-component>

@endsection
