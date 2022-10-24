package com.google.ar.core.examples.java.helloar;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.google.ar.core.examples.java.webapi.WebApi;
import com.google.ar.core.examples.java.webapi.WebApiThread;
import com.google.ar.core.examples.java.webapi.models.*;

public class StartUpActivity extends Activity {

    Button buttonGuestEnter, buttonLogin, buttonForgotPassword, buttonRegister;
    EditText email, password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        String token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJsb2NhdGlvbiI6ImFueXdoZXJlIiwiaWF0IjoxNjY1NTIyMjc1fQ.DLmaU9h7LBLV8uxdhQXJBgOUS3QjDZOVkb8gQShVgBI";
        WebApiThread.getInstance().setToken(token);

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_start);

        buttonGuestEnter        = findViewById(R.id.buttonGuestEnter);
        buttonLogin             = findViewById(R.id.buttonLogin);
        buttonForgotPassword    = findViewById(R.id.buttonForgotPassword);
        buttonRegister          = findViewById(R.id.buttonRegister);
        email                   = findViewById(R.id.editTextTextEmailAddress);
        password                = findViewById(R.id.editTextTextPassword);

        buttonForgotPassword.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                AlertDialog.Builder alert = new AlertDialog.Builder(StartUpActivity.this);

                final EditText edittext = new EditText(StartUpActivity.this);
                edittext.setHint("Email");
                //alert.setMessage("Enter Your Message");
                alert.setTitle("Reset Password");

                alert.setView(edittext);

                alert.setPositiveButton("Submit", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int whichButton) {
                        String YouEditTextValue = edittext.getText().toString();
                        Toast toast = Toast.makeText(StartUpActivity.this,
                                                    "An email has been sent with instructions to reset your password",
                                                    Toast.LENGTH_SHORT);
                        toast.show();
                        dialog.dismiss();
                    }
                });

                alert.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int whichButton) {
                        // what ever you want to do with No option.
                        dialog.dismiss();
                    }
                });

                alert.show();
            }
        });
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
        Intent intent = new Intent(this, RegisterActivity.class);
        startActivity(intent);
    }
}
