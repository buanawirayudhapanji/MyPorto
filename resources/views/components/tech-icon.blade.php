@props(['name', 'class' => 'size-4'])

@php
    $slug = strtolower(trim($name));
    $map = [
        // Languages
        'php' => 'php/php-original.svg',
        'javascript' => 'javascript/javascript-original.svg',
        'js' => 'javascript/javascript-original.svg',
        'typescript' => 'typescript/typescript-original.svg',
        'ts' => 'typescript/typescript-original.svg',
        'python' => 'python/python-original.svg',
        'py' => 'python/python-original.svg',
        'ruby' => 'ruby/ruby-original.svg',
        'java' => 'java/java-original.svg',
        'kotlin' => 'kotlin/kotlin-original.svg',
        'swift' => 'swift/swift-original.svg',
        'go' => 'go/go-original.svg',
        'golang' => 'go/go-original.svg',
        'rust' => 'rust/rust-original.svg',
        'c' => 'c/c-original.svg',
        'c++' => 'cplusplus/cplusplus-original.svg',
        'cpp' => 'cplusplus/cplusplus-original.svg',
        'c#' => 'csharp/csharp-original.svg',
        'csharp' => 'csharp/csharp-original.svg',
        'html' => 'html5/html5-original.svg',
        'html5' => 'html5/html5-original.svg',
        'css' => 'css3/css3-original.svg',
        'css3' => 'css3/css3-original.svg',
        'sql' => 'mysql/mysql-original.svg', // Map generic SQL to mysql icon as fallback

        // Frameworks & Libraries
        'laravel' => 'laravel/laravel-original.svg',
        'livewire' => 'livewire/livewire-original.svg',
        'symfony' => 'symfony/symfony-original.svg',
        'codeigniter' => 'codeigniter/codeigniter-original.svg',
        'django' => 'django/django-plain.svg',
        'flask' => 'flask/flask-original.svg',
        'fastapi' => 'fastapi/fastapi-original.svg',
        'ruby on rails' => 'rails/rails-original-wordmark.svg',
        'rails' => 'rails/rails-original-wordmark.svg',
        'spring' => 'spring/spring-original.svg',
        'spring boot' => 'spring/spring-original.svg',
        'react' => 'react/react-original.svg',
        'reactjs' => 'react/react-original.svg',
        'react.js' => 'react/react-original.svg',
        'vue' => 'vuejs/vuejs-original.svg',
        'vuejs' => 'vuejs/vuejs-original.svg',
        'vue.js' => 'vuejs/vuejs-original.svg',
        'angular' => 'angular/angular-original.svg',
        'angularjs' => 'angular/angular-original.svg',
        'svelte' => 'svelte/svelte-original.svg',
        'nextjs' => 'nextjs/nextjs-original.svg',
        'next.js' => 'nextjs/nextjs-original.svg',
        'nuxtjs' => 'nuxtjs/nuxtjs-original.svg',
        'nuxt.js' => 'nuxtjs/nuxtjs-original.svg',
        'express' => 'express/express-original.svg',
        'expressjs' => 'express/express-original.svg',
        'nestjs' => 'nestjs/nestjs-original.svg',
        'flutter' => 'flutter/flutter-original.svg',
        'react native' => 'react/react-original.svg',
        'tailwind' => 'tailwindcss/tailwindcss-original.svg',
        'tailwindcss' => 'tailwindcss/tailwindcss-original.svg',
        'tailwind css' => 'tailwindcss/tailwindcss-original.svg',
        'bootstrap' => 'bootstrap/bootstrap-original.svg',
        'sass' => 'sass/sass-original.svg',
        'less' => 'less/less-plain-wordmark.svg',
        'jquery' => 'jquery/jquery-original.svg',

        // Databases
        'mysql' => 'mysql/mysql-original.svg',
        'postgresql' => 'postgresql/postgresql-original.svg',
        'postgres' => 'postgresql/postgresql-original.svg',
        'sqlite' => 'sqlite/sqlite-original.svg',
        'mariadb' => 'mariadb/mariadb-original.svg',
        'mongodb' => 'mongodb/mongodb-original.svg',
        'mongo' => 'mongodb/mongodb-original.svg',
        'redis' => 'redis/redis-original.svg',
        'firebase' => 'firebase/firebase-original.svg',
        'supabase' => 'supabase/supabase-original.svg',

        // DevOps & Platforms
        'docker' => 'docker/docker-original.svg',
        'docker compose' => 'docker/docker-original.svg',
        'docker-compose' => 'docker/docker-original.svg',
        'kubernetes' => 'kubernetes/kubernetes-original.svg',
        'k8s' => 'kubernetes/kubernetes-original.svg',
        'aws' => 'amazonwebservices/amazonwebservices-original-wordmark.svg',
        'amazon web services' => 'amazonwebservices/amazonwebservices-original-wordmark.svg',
        'gcp' => 'googlecloud/googlecloud-original.svg',
        'google cloud' => 'googlecloud/googlecloud-original.svg',
        'azure' => 'azure/azure-original.svg',
        'vercel' => 'vercel/vercel-original.svg',
        'netlify' => 'netlify/netlify-original.svg',
        'heroku' => 'heroku/heroku-original.svg',
        'nginx' => 'nginx/nginx-original.svg',
        'apache' => 'apache/apache-original.svg',
        'git' => 'git/git-original.svg',
        'github' => 'github/github-original.svg',
        'gitlab' => 'gitlab/gitlab-original.svg',
        'terraform' => 'terraform/terraform-original.svg',

        // Systems
        'linux' => 'linux/linux-original.svg',
        'ubuntu' => 'ubuntu/ubuntu-original.svg',
        'mac' => 'apple/apple-original.svg',
        'macos' => 'apple/apple-original.svg',
        'windows' => 'windows8/windows8-original.svg',
        'android' => 'android/android-original.svg',
        'ios' => 'apple/apple-original.svg',
        
        // Others
        'figma' => 'figma/figma-original.svg',
        'wordpress' => 'wordpress/wordpress-original.svg',
        'npm' => 'npm/npm-original-wordmark.svg',
        'yarn' => 'yarn/yarn-original.svg',
        'vite' => 'vite/vite-original.svg',
    ];

    $path = $map[$slug] ?? null;
    if (!$path) {
        $clean = preg_replace('/[^a-z0-9]/', '', $slug);
        $path = $clean . '/' . $clean . '-original.svg';
    }
    
    $url = "https://cdn.jsdelivr.net/gh/devicons/devicon@v2.17.0/icons/" . $path;
@endphp

<img 
    src="{{ $url }}" 
    class="{{ $class }} inline-block object-contain {{ $slug === 'github' ? 'dark:invert' : '' }}" 
    alt="{{ $name }}"
    onerror="this.style.display='none'; this.nextElementSibling ? this.nextElementSibling.style.paddingLeft='0' : null;"
/>
