<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-bell"></i>
    @if($unread)
    <span class="badge badge-warning navbar-badge">{{ $unread }}</span>
    @endif
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <span class="dropdown-header">{{ $unread }} {{ __('Notifications') }}</span>
    @foreach($notifications as $notification)
    <div class="dropdown-divider"></div>
    <a href="{{ route('notifications.read', [$notification->id]) }}" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i> $notification->data['message']
        <span class="float-right text-muted text-sm"><i class="far fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}</span>
    </a>
    @endforeach
    <div class="dropdown-divider"></div>
    <a href="{{ route('notifications') }}" class="dropdown-item dropdown-footer">{{ __('See All Notifications') }}</a>
</div>