package com.google.ar.core.examples.java.helloar;

import android.app.Activity;
import android.graphics.Color;
import android.os.Bundle;
import android.view.View;

import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import android.content.Intent;



public class StartUpActivity extends Activity {

    Button buttonGuestEnter, buttonLogin, buttonForgotPassword, buttonRegister;
    EditText email, password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_start);

        buttonGuestEnter        = findViewById(R.id.buttonGuestEnter);
        buttonLogin             = findViewById(R.id.buttonLogin);
        buttonForgotPassword    = findViewById(R.id.buttonForgotPassword);
        buttonRegister          = findViewById(R.id.buttonRegister);
        email                   = findViewById(R.id.editTextTextEmailAddress);
        password                = findViewById(R.id.editTextTextPassword);
    }

    public void guestEnter(View v) {
        Intent intent = new Intent(this, HomeActivity.class);
        startActivity(intent);
    }

    public void loginButton(View v) {
        Intent intent = new Intent(this, HomeActivity.class);
        startActivity(intent);
    }

    public void forgotPasswordButton(View v) {
        Intent intent = new Intent(this, HomeActivity.class);
        startActivity(intent);
    }

    public void registerButton(View v) {
        Intent intent = new Intent(this, HomeActivity.class);
        startActivity(intent);
    }
}
