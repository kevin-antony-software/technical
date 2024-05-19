<li class="nav-item">
    <a href="{{ route('repair_job.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle text-success"></i>
        <p class="text-success">Repair job</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('common_issue.index') }}" class="nav-link">
        <i class="nav-icon far fa-circle"></i>
        <p class="text">Common issue</p>
    </a>
</li>
@can('senior-tech-executive-only')
    <li class="nav-item">
        <a href="{{ route('expense.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-danger"></i>
            <p class="text-danger">Expense</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customer.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle"></i>
            <p class="text">Customer</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('payment.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-success"></i>
            <p class="text-success">Payment</p>
        </a>
    </li>
@endcan

@can('managers-only')
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

    <li class="nav-item">
        <a href="{{ route('component_purchase.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle text-success"></i>
            <p class="text text-success">Component purchase</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('courier_weight_charge.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle"></i>
            <p class="text">Courier Weight</p>
        </a>
    </li>
@endcan

@can('director-only')
    <li class="nav-item">
        <a href="{{ route('user.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle"></i>
            <p class="text">User</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('bank.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle"></i>
            <p class="text">Bank</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('cash.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle"></i>
            <p class="text">Cash</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('cheque.index') }}" class="nav-link">
            <i class="nav-icon far fa-circle"></i>
            <p class="text">Cheque</p>
        </a>
    </li>
@endcan
<li class="nav-header">REPORTS</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-regular fa-star"></i>
        <p>REPORTS<i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('report.closed_jobs') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Closed Jobs</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('report.today_closed_jobs') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Today Closed Jobs</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('report.outstanding') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Outstanding</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('report.closed_summary') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>closed_summary</p>
            </a>
        </li>
    </ul>
</li>
