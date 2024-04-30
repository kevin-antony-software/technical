<li class="nav-item">
    <a href="{{ route('customer.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Customer</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('component_category.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Component Category</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('component.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Component</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('machine_model.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Machine Model</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('component_stock.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Component Stock</p>
    </a>
</li>
@can('managers-only')
    <li class="nav-item">
        <a href="{{ route('component_purchase.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle"></i>
            <p class="text">Component purchase</p>
        </a>
    </li>
@endcan

<li class="nav-item">
    <a href="{{ route('courier_weight_charge.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Courier Weight</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('common_issue.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Common issue</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('repair_job.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Repair job</p>
    </a>
</li>
@can('director-only')
    <li class="nav-item">
        <a href="{{ route('user.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle"></i>
            <p class="text">User</p>
        </a>
    </li>
@endcan
@can('director-only')
    <li class="nav-item">
        <a href="{{ route('bank.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle"></i>
            <p class="text">Bank</p>
        </a>
    </li>
@endcan

<li class="nav-item">
    <a href="{{ route('cash.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Cash</p>
    </a>
</li>

