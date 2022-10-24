package com.google.ar.core.examples.java.webapi.models;

public class MediaInstance {
    public int id;
    public float x;
    public float y;
    public float z;
    public float scale_x;
    public float scale_y;
    public float scale_z;
    public int mediaId;
    public int videoId;

    @Override
    public String toString() {
        return String.format("%d\n%f\n%f\n%f\n%f\n%f\n%f\n%d\n%d", id, x, y, z, scale_x, scale_y, scale_z, mediaId, videoId);
    }
}
