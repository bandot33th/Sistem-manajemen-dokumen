
// branch folder di add user
window.toggleBranch = function (...branchIds) {
    branchIds.forEach(id => {
        const branch = document.getElementById(id);
        if (branch) {
            branch.classList.toggle('hidden');
        }
    });     
};

// In your Javascript (external .js resource or <script> tag)
