<x-admin.nav>
    <div class="container">
        <form method="POST" action="{{ route('repair_job.uploadImageSave', $job->id) }}" enctype="multipart/form-data">
            @csrf
            {{-- @method('PUT') --}}

                <div class="col-md-12 p-2">
                    <input type="file" name="image1" id = "image1" class="form-control">
                </div>
                <div class="col-md-12 p-2">
                    <input type="file" name="image2" id = "image2"class="form-control">
                </div>
                <div class="col-md-12 p-2">
                    <input type="file" name="image3" id = "image3" class="form-control">
                </div>
                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-block btn-secondary" href="{{ route('repair_job.index') }}" role="button">Go Back
                            to Index</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-block btn-primary">Upload</button>
                    </div>
                </div>

        </form>
    </div>
</x-admin.nav>
