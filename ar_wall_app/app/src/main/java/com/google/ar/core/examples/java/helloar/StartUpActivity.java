package com.google.ar.core.examples.java.helloar;

import android.app.Activity;
import android.graphics.Color;
import android.os.Bundle;
import android.view.View;

import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class StartUpActivity extends Activity {
    Button buttonGuestEnter, buttonLogin, buttonForgotPassword, buttonRegister;
    EditText email, password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_start);

        buttonGuestEnter = (Button)findViewById(R.id.buttonGuestEnter);
        buttonLogin = (Button)findViewById(R.id.buttonLogin);
        buttonForgotPassword = (Button)findViewById(R.id.buttonForgotPassword);
        buttonRegister = (Button)findViewById(R.id.buttonRegister);
        email = (EditText) findViewById(R.id.editTextTextEmailAddress);
        password = (EditText) findViewById(R.id.editTextTextPassword);

        buttonGuestEnter.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        buttonLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(email.getText().toString().equals("admin") && password.getText().toString().equals("admin")) {
                    Toast.makeText(getApplicationContext(),"Redirecting...",Toast.LENGTH_SHORT).show();
                }else{
                    Toast.makeText(getApplicationContext(), "Wrong Credentials",Toast.LENGTH_SHORT).show();
                }
            }
        });

        buttonForgotPassword.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        buttonRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });
    }
}
