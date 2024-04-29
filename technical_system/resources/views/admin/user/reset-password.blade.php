<x-admin.nav>
    <div class="container">
        <form method="POST" action="{{ route('user.changePasswordSave') }}">
            @csrf
                        <input type="hidden" id="userID" name = "userID" value={{ $user->id }}>

                        <div class="mb-3">
                            <label for="password"  class="form-label" >New Password</label>

                            <input id="password" class="form-control"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation"  class="form-label" >Confirm New Password</label>

                            <input id="password_confirmation" class="form-control"
                                            type="password"
                                            name="password_confirmation" required />
                        </div>

            <button class="btn btn-block btn-primary" type="submit">Save New Password</button>
        </form>
    </div>
</x-admin.nav>
