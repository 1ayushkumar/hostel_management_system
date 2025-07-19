#!/bin/bash

# Deployment script for Render
echo "🚀 Starting Hostel Management System deployment..."

# Check if we're on Render
if [ -n "$RENDER" ]; then
    echo "📦 Detected Render environment"
    
    # Install any additional PHP extensions if needed
    echo "🔧 Setting up PHP environment..."
    
    # Set up database if DATABASE_URL exists
    if [ -n "$DATABASE_URL" ]; then
        echo "🗄️ Setting up database..."
        
        # Run database migrations/setup
        php -r "
        try {
            \$databaseUrl = parse_url(\$_ENV['DATABASE_URL']);
            \$host = \$databaseUrl['host'];
            \$port = \$databaseUrl['port'] ?? 5432;
            \$dbname = ltrim(\$databaseUrl['path'], '/');
            \$username = \$databaseUrl['user'];
            \$password = \$databaseUrl['pass'];
            
            \$dsn = \"pgsql:host=\$host;port=\$port;dbname=\$dbname\";
            \$pdo = new PDO(\$dsn, \$username, \$password);
            
            // Check if tables exist, if not, run schema
            \$result = \$pdo->query(\"SELECT COUNT(*) FROM information_schema.tables WHERE table_name = 'staff'\");
            if (\$result->fetchColumn() == 0) {
                echo \"Creating database schema...\n\";
                \$schema = file_get_contents('hostel_management_postgresql.sql');
                \$pdo->exec(\$schema);
                echo \"Database schema created successfully!\n\";
            } else {
                echo \"Database schema already exists.\n\";
            }
        } catch (Exception \$e) {
            echo \"Database setup error: \" . \$e->getMessage() . \"\n\";
        }
        "
    fi
    
    echo "✅ Deployment setup complete!"
else
    echo "🏠 Local development environment detected"
fi

echo "🎉 Ready to serve!"
