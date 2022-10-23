package com.google.ar.core.examples.java.webapi.models;

public class Moderator {
    public int id;
    public String email;
    public String username;
    public String password;

    @Override
    public String toString() {
        return String.format("%d\n%s\n%s\n%s", id, email, username, password);
    }
}
