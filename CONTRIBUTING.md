# Contributing to Hostel Management System

First off, thank you for considering contributing to the Hostel Management System! It's people like you that make this project a great tool for hostel management.

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)

## Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code.

## Getting Started

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP/WAMP/LAMP server
- Git for version control
- Code editor (VS Code, PHPStorm, etc.)

### Development Setup

1. **Fork the repository**
   ```bash
   # Click the "Fork" button on GitHub
   ```

2. **Clone your fork**
   ```bash
   git clone https://github.com/yourusername/hostel-management-system.git
   cd hostel-management-system
   ```

3. **Set up the development environment**
   ```bash
   # Copy to your web server directory
   # For XAMPP: C:\xampp\htdocs\hostel_management_system
   
   # Import database
   # Create database: hostel_management
   # Import: hostel_management.sql
   # Import sample data: sample_data.sql
   ```

4. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

## How Can I Contribute?

### 🐛 Reporting Bugs

Before creating bug reports, please check the existing issues to avoid duplicates.

**When submitting a bug report, please include:**
- Clear, descriptive title
- Steps to reproduce the issue
- Expected vs actual behavior
- Screenshots (if applicable)
- System information (PHP version, browser, OS)
- Error messages or logs

### 💡 Suggesting Features

Feature suggestions are welcome! Please:
- Check existing feature requests first
- Clearly describe the feature and its benefits
- Explain the use case
- Consider implementation complexity

### 🔧 Code Contributions

#### Areas where contributions are welcome:
- Bug fixes
- New features
- Performance improvements
- UI/UX enhancements
- Documentation improvements
- Test coverage
- Security enhancements

## Coding Standards

### PHP Standards
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add PHPDoc comments for functions and classes
- Validate and sanitize all user inputs
- Use prepared statements for database queries

```php
<?php
/**
 * Get student information by ID
 * 
 * @param int $studentId The student ID
 * @return array|false Student data or false if not found
 */
function getStudentById($studentId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM Student WHERE StudentID = ?");
    $stmt->execute([$studentId]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
```

### HTML/CSS Standards
- Use semantic HTML5 elements
- Follow Bootstrap conventions
- Maintain responsive design
- Use consistent indentation (4 spaces)
- Add comments for complex CSS

### JavaScript Standards
- Use ES6+ features when appropriate
- Add JSDoc comments for functions
- Handle errors gracefully
- Use consistent naming conventions

```javascript
/**
 * Update dashboard statistics
 * @param {Object} stats - Statistics object
 */
function updateDashboardStats(stats) {
    try {
        document.getElementById('totalStudents').textContent = stats.totalStudents;
        document.getElementById('availableRooms').textContent = stats.availableRooms;
        // ... more updates
    } catch (error) {
        console.error('Error updating dashboard stats:', error);
    }
}
```

### Database Standards
- Use descriptive table and column names
- Add appropriate indexes
- Include foreign key constraints
- Write efficient queries
- Add comments for complex queries

## Commit Guidelines

### Commit Message Format
```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types
- **feat**: New feature
- **fix**: Bug fix
- **docs**: Documentation changes
- **style**: Code style changes (formatting, etc.)
- **refactor**: Code refactoring
- **test**: Adding or updating tests
- **chore**: Maintenance tasks

### Examples
```bash
feat(students): add bulk student import functionality

- Add CSV import feature for student data
- Include validation for required fields
- Add progress indicator for large imports

Closes #123
```

```bash
fix(rooms): resolve room assignment validation issue

- Fix gender compatibility check
- Prevent assignment to full rooms
- Add proper error messages

Fixes #456
```

## Pull Request Process

1. **Ensure your code follows the coding standards**
2. **Update documentation** if needed
3. **Add or update tests** for your changes
4. **Test thoroughly** on different browsers/devices
5. **Update the README.md** if you've added new features

### Pull Request Template
```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation update
- [ ] Performance improvement

## Testing
- [ ] Tested on Chrome
- [ ] Tested on Firefox
- [ ] Tested on mobile devices
- [ ] Added/updated tests

## Screenshots (if applicable)
Add screenshots of UI changes

## Checklist
- [ ] Code follows project standards
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] No breaking changes
```

### Review Process
1. **Automated checks** must pass
2. **Code review** by maintainers
3. **Testing** on different environments
4. **Approval** from at least one maintainer
5. **Merge** into main branch

## Development Tips

### Debugging
- Enable PHP error reporting in development
- Use browser developer tools
- Check PHP and MySQL error logs
- Use var_dump() and console.log() for debugging

### Testing
- Test all user roles and permissions
- Verify responsive design on different screen sizes
- Check form validation (client and server-side)
- Test database operations thoroughly

### Performance
- Optimize database queries
- Minimize HTTP requests
- Use appropriate caching strategies
- Optimize images and assets

## Questions?

If you have questions about contributing, please:
- Check existing documentation
- Search through issues
- Create a new issue with the "question" label
- Contact the maintainers

Thank you for contributing to the Hostel Management System! 🎉
