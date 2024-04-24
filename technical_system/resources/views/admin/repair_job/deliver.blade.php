<x-admin.nav>
    <div class="container">
        <h2>Job Delivery Form</h2>
        <form method="POST" action="{{ route('repair_job.deliverSave', $job->id) }}">
            @csrf
            <div class="form-group">
                <label for="promptOut">prompt Out</label>
                <input class="form-control" type="text" id="promptOut" name="promptOut" required>
            </div>
            <div class="form-group">
                <label for="comment">Comment</label>
                <input class="form-control" type="text" id="comment" name="comment">
            </div>
            <div class="container pt-5">
                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-block btn-secondary" href="{{ route('repair_job.index') }}" role="button">Go Back
                            to Index</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-block btn-primary">Deliver Repair Job</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-admin.nav>
