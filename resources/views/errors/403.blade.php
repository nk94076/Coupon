@include('errors.minimal', [
    'code' => 403,
    'title' => 'Access denied',
    'message' => "You don't have permission to view this page. Contact a super admin if you think this is a mistake.",
])
