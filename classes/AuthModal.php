<?php
/**
 * AuthModal Class
 * Handles user authentication modals (Login/Signup)
 */
class AuthModal {
    
    public function render() {
        ?>
        <!-- Login Modal -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content auth-modal">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="loginModalLabel">
                            <i class="fas fa-sign-in-alt me-2"></i>Welcome Back
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="loginEmail" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="loginPassword" placeholder="Enter your password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Remember me
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                            <div class="text-center">
                                <a href="#" class="text-muted small">Forgot password?</a>
                            </div>
                        </form>
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="mb-2">Don't have an account?</p>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#signupModal" data-bs-dismiss="modal">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signup Modal -->
        <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content auth-modal">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="signupModalLabel">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="signupForm">
                            <div class="mb-3">
                                <label for="signupName" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="signupName" placeholder="Enter your name" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="signupEmail" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="signupEmail" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="signupPhone" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel" class="form-control" id="signupPhone" placeholder="Enter your phone number" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="signupPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="signupPassword" placeholder="Create a password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleSignupPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Minimum 8 characters</small>
                            </div>
                            <div class="mb-3">
                                <label for="signupConfirmPassword" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="signupConfirmPassword" placeholder="Confirm your password" required>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                                <label class="form-check-label" for="agreeTerms">
                                    I agree to the <a href="#" class="text-primary">Terms & Conditions</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </form>
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="mb-2">Already have an account?</p>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown (shown when logged in) -->
        <div id="userProfileDropdown" style="display: none;">
            <div class="dropdown">
                <button class="btn btn-user-profile dropdown-toggle" type="button" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle me-2"></i>
                    <span id="userDisplayName">User</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                    <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>My Profile</a></li>
                    <li><a class="dropdown-item" href="profile.php#orders"><i class="fas fa-shopping-bag me-2"></i>My Orders</a></li>
                    <li><a class="dropdown-item" href="profile.php#favorites"><i class="fas fa-heart me-2"></i>Favorites</a></li>
                    <li><a class="dropdown-item" href="profile.php#addresses"><i class="fas fa-map-marker-alt me-2"></i>Addresses</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" id="logoutBtn"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
        <?php
    }
}
